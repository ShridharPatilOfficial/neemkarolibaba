<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_videos', function (Blueprint $table) {
            $table->smallInteger('post_year')->unsigned()->default(0)->after('sort_order');
        });
        DB::statement("UPDATE `work_videos` SET post_year = YEAR(created_at)");
    }

    public function down(): void
    {
        Schema::table('work_videos', function (Blueprint $table) {
            $table->dropColumn('post_year');
        });
    }
};
