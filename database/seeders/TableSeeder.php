<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Table;


class TableSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            Table::create([
                'table_number' => 'Table ' . $i,
                'seats' => 4,
                'status' => $i % 2 == 1 ? 'not available' : 'available',
            ]);
        }
    }
}
