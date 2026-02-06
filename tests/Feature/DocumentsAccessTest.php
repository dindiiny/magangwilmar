<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentsAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_documents_index()
    {
        $response = $this->get('/dokumen-laporan');
        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_documents_index()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $response = $this->actingAs($user)->get('/dokumen-laporan');
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_documents_index()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->get('/dokumen-laporan');
        $response->assertStatus(200);
    }
}
