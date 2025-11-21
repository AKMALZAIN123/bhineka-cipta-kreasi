<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $product1 = Product::create([
            'name' => 'Custom T-Shirt',
            'category' => 'Clothing',
            'size' => 'M',
            'price' => 150000,
            'description' => 'Custom printed t-shirt with your design',
        ]);

        $product2 = Product::create([
            'name' => 'Custom Mug',
            'category' => 'Drinkware',
            'size' => '350ml',
            'price' => 75000,
            'description' => 'Ceramic mug with custom print',
        ]);

        $product3 = Product::create([
            'name' => 'Custom Hoodie',
            'category' => 'Clothing',
            'size' => 'L',
            'price' => 250000,
            'description' => 'Premium hoodie with custom design',
        ]);

        $product4 = Product::create([
            'name' => 'Custom Tote Bag',
            'category' => 'Accessories',
            'size' => 'Standard',
            'price' => 100000,
            'description' => 'Canvas tote bag with custom print',
        ]);
    }
}
