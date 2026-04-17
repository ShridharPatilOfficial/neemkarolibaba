<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['activities', 'events', 'future_plans'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->smallInteger('post_year')->unsigned()->default(0)->after('sort_order');
            });
            // Back-fill existing rows with their created_at year
            DB::statement("UPDATE `{$table}` SET post_year = YEAR(created_at)");
        }
    }

    public function down(): void
    {
        foreach (['activities', 'events', 'future_plans'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('post_year');
            });
        }
    }
};
