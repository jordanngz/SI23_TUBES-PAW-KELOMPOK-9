<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Aman dijalankan berulang — truncate dulu sebelum insert.
     */
    public function run(): void
    {
        // Disable foreign key checks agar truncate tidak error
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::table('products')->truncate();
        DB::table('tables')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->call([
            TableSeeder::class,
            SpecialTableSeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
        ]);
    }
}
