<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('seven_summaries') && !Schema::hasColumn('seven_summaries', 'report_file')) {
            Schema::table('seven_summaries', function (Blueprint $table) {
                $table->string('report_file')->nullable()->after('report');
            });
        }
    }

    public function down(): void
    {
        Schema::table('seven_summaries', function (Blueprint $table) {
            $table->dropColumn('report_file');
        });
    }
};
