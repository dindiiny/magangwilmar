<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('seven_reports') && !Schema::hasColumn('seven_reports', 'title')) {
            Schema::table('seven_reports', function (Blueprint $table) {
                $table->string('title')->nullable()->after('seven_s_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('seven_reports') && Schema::hasColumn('seven_reports', 'title')) {
            Schema::table('seven_reports', function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }
    }
};

