<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Use this in PRODUCTION only.
     * Command: php artisan db:seed --class=AdminUserSeeder
     */
    public function run(): void
    {
        DB::table('admin_users')->insertOrIgnore([
            'name'       => 'Admin',
            'email'      => 'admin@nkbfoundation.org',
            'password'   => Hash::make('Admin@1234'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
