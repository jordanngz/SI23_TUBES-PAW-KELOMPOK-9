<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;

class SpecialTableSeeder extends Seeder
{
    public function run(): void
    {
        $specialTables = [
            [
                'table_number' => 'VIP-01',
                'seats'        => 10,
                'status'       => 'available',
                'type'         => 'special',
                'image'        => 'Meja.jpg',
            ],
            [
                'table_number' => 'VIP-02',
                'seats'        => 8,
                'status'       => 'available',
                'type'         => 'special',
                'image'        => 'Meja.jpg',
            ],
            [
                'table_number' => 'VIP-03',
                'seats'        => 12,
                'status'       => 'available',
                'type'         => 'special',
                'image'        => 'Meja.jpg',
            ],
            [
                'table_number' => 'SUITE-01',
                'seats'        => 16,
                'status'       => 'available',
                'type'         => 'special',
                'image'        => 'Meja.jpg',
            ],
            [
                'table_number' => 'SUITE-02',
                'seats'        => 20,
                'status'       => 'available',
                'type'         => 'special',
                'image'        => 'Meja.jpg',
            ],
        ];

        foreach ($specialTables as $data) {
            // updateOrCreate agar bisa dijalankan ulang tanpa duplikat
            Table::updateOrCreate(
                ['table_number' => $data['table_number']],
                $data
            );
        }

        $this->command->info('✅ Special tables seeded: VIP-01, VIP-02, VIP-03, SUITE-01, SUITE-02');
    }
}
