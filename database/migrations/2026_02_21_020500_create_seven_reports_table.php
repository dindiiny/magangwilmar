<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('seven_reports')) {
            Schema::create('seven_reports', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('seven_s_id');
                $table->longText('content')->nullable();
                $table->string('file_path')->nullable();
                $table->timestamps();
            });
        }

        if (Schema::hasTable('seven_summaries') && Schema::hasTable('seven_reports')) {
            $rows = DB::table('seven_summaries')
                ->whereNotNull('report')
                ->orWhereNotNull('report_file')
                ->get();

            foreach ($rows as $row) {
                DB::table('seven_reports')->insert([
                    'seven_s_id' => $row->id,
                    'content' => $row->report,
                    'file_path' => $row->report_file,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('seven_reports');
    }
};

