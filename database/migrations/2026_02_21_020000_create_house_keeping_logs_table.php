<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('house_keeping_logs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('day_name', 20);
            $table->text('activities')->nullable();
            $table->text('areas')->nullable();
            $table->string('video_path')->nullable();
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('house_keeping_logs');
    }
};

