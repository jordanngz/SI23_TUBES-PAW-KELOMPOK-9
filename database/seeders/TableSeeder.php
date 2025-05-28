<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            Table::create([
                'table_number' => ' ' . $i,
                'seats' => 4,
                'status' => $i % 2 == 1 ? 'reserved' : 'available', // ✅ hanya 'reserved' atau 'available'
            ]);
        }
    }
}
