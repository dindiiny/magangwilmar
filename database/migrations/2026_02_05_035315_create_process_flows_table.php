<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('process_flows', function (Blueprint $table) {
            $table->id();
            $table->string('step_name'); // e.g., 'Sampel Awal', 'Turunan'
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('order')->default(0); // To control the flow sequence
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_flows');
    }
};
