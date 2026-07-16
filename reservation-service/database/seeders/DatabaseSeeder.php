<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('tables')->truncate();
        DB::table('reservations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->call([
            TableSeeder::class,
            SpecialTableSeeder::class,
        ]);
    }
}
