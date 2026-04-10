<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->string('country', 100)->nullable()->after('visited_date');
            $table->string('country_code', 3)->nullable()->after('country');
            $table->string('region', 100)->nullable()->after('country_code');
            $table->string('city', 100)->nullable()->after('region');
            $table->string('timezone', 100)->nullable()->after('city');
            $table->string('isp', 200)->nullable()->after('timezone');
            $table->decimal('lat', 10, 6)->nullable()->after('isp');
            $table->decimal('lon', 10, 6)->nullable()->after('lat');
            $table->string('device_type', 20)->nullable()->after('lon');   // mobile/tablet/desktop
            $table->string('browser', 50)->nullable()->after('device_type');
            $table->string('os', 50)->nullable()->after('browser');
            $table->string('referrer', 500)->nullable()->after('os');
            $table->boolean('geo_resolved')->default(false)->after('referrer');
        });
    }

    public function down(): void
    {
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->dropColumn([
                'country', 'country_code', 'region', 'city', 'timezone', 'isp',
                'lat', 'lon', 'device_type', 'browser', 'os', 'referrer', 'geo_resolved',
            ]);
        });
    }
};
