<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('seven_summaries')) {
            Schema::table('seven_summaries', function (Blueprint $table) {
                if (!Schema::hasColumn('seven_summaries', 'seiri_text')) {
                    $table->text('seiri_text')->nullable()->after('seiri');
                }
                if (!Schema::hasColumn('seven_summaries', 'seiton_text')) {
                    $table->text('seiton_text')->nullable()->after('seiton');
                }
                if (!Schema::hasColumn('seven_summaries', 'seiso_text')) {
                    $table->text('seiso_text')->nullable()->after('seiso');
                }
                if (!Schema::hasColumn('seven_summaries', 'seiketsu_text')) {
                    $table->text('seiketsu_text')->nullable()->after('seiketsu');
                }
                if (!Schema::hasColumn('seven_summaries', 'shitsuke_text')) {
                    $table->text('shitsuke_text')->nullable()->after('shitsuke');
                }
                if (!Schema::hasColumn('seven_summaries', 'safety_text')) {
                    $table->text('safety_text')->nullable()->after('safety_spirit');
                }
                if (!Schema::hasColumn('seven_summaries', 'spirit_text')) {
                    $table->text('spirit_text')->nullable()->after('safety_text');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('seven_summaries')) {
            Schema::table('seven_summaries', function (Blueprint $table) {
                if (Schema::hasColumn('seven_summaries', 'seiri_text')) {
                    $table->dropColumn('seiri_text');
                }
                if (Schema::hasColumn('seven_summaries', 'seiton_text')) {
                    $table->dropColumn('seiton_text');
                }
                if (Schema::hasColumn('seven_summaries', 'seiso_text')) {
                    $table->dropColumn('seiso_text');
                }
                if (Schema::hasColumn('seven_summaries', 'seiketsu_text')) {
                    $table->dropColumn('seiketsu_text');
                }
                if (Schema::hasColumn('seven_summaries', 'shitsuke_text')) {
                    $table->dropColumn('shitsuke_text');
                }
                if (Schema::hasColumn('seven_summaries', 'safety_text')) {
                    $table->dropColumn('safety_text');
                }
                if (Schema::hasColumn('seven_summaries', 'spirit_text')) {
                    $table->dropColumn('spirit_text');
                }
            });
        }
    }
};

