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
                'name' => 'Kerapu With Lemon Butter Sauce',
                'description' => 'Norwegian Kerapu with lemon butter sauce.',
                'price' => 42.00,
                'image' => 'menu_images/Kerapu.jpg',
            ],
            [
                'name' => 'Filet Mignon',
                'description' => 'Beef tenderloin with truffle mashed potatoes.',
                'price' => 58.00,
                'image' => 'menu_images/Fillet_Mignon.jpg',
            ],
            [
                'name' => 'Chocolate Soufflé',
                'description' => 'Dark chocolate dessert with ice cream.',
                'price' => 18.00,
                'image' => 'menu_images/Chocolate.jpg',
            ]
        ]);
    }
}