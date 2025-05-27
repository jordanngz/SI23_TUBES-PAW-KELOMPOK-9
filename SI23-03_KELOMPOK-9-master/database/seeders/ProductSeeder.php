<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Grilled Salmon',
                'description' => 'Norwegian salmon with lemon butter sauce.',
                'price' => 42.00,
                'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=2069&auto=format&fit=crop',
            ],
            [
                'name' => 'Filet Mignon',
                'description' => 'Beef tenderloin with truffle mashed potatoes.',
                'price' => 58.00,
                'image' => 'https://images.unsplash.com/photo-1546833998-877b37c2e4c6?q=80&w=2070&auto=format&fit=crop',
            ],
            [
                'name' => 'Chocolate Soufflé',
                'description' => 'Dark chocolate dessert with ice cream.',
                'price' => 18.00,
                'image' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=1964&auto=format&fit=crop',
            ]
        ]);
    }
}
