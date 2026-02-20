<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('seven_summaries')) {
            Schema::create('seven_summaries', function (Blueprint $table) {
                $table->id();
                $table->unsignedTinyInteger('progress_percent')->default(0);
                $table->string('before_image')->nullable();
                $table->string('after_image')->nullable();
                $table->boolean('seiri')->default(false);
                $table->boolean('seiton')->default(false);
                $table->boolean('seiso')->default(false);
                $table->boolean('seiketsu')->default(false);
                $table->boolean('shitsuke')->default(false);
                $table->boolean('safety_spirit')->default(false);
                $table->longText('report')->nullable();
                $table->string('report_file')->nullable();
                $table->boolean('published')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('seven_summaries');
    }
};

