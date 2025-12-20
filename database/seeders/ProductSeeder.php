<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedProduct(
            name: 'Custom T-Shirt',
            category: 'Clothing',
            size: 'M',
            price: 150000,
            description: 'Custom printed t-shirt with your design',
            assetFile: database_path('seeders/assets/tshirt.jpg')
        );

        $this->seedProduct(
            name: 'Custom Mug',
            category: 'Drinkware',
            size: '350ml',
            price: 75000,
            description: 'Ceramic mug with custom print',
            assetFile: database_path('seeders/assets/mug.jpg')
        );

        $this->seedProduct(
            name: 'Custom Hoodie',
            category: 'Clothing',
            size: 'L',
            price: 250000,
            description: 'Premium hoodie with custom design',
            assetFile: database_path('seeders/assets/hoodie.jpg')
        );

        $this->seedProduct(
            name: 'Custom Tote Bag',
            category: 'Accessories',
            size: 'Standard',
            price: 100000,
            description: 'Canvas tote bag with custom print',
            assetFile: database_path('seeders/assets/totebag.jpg')
        );
    }

    private function seedProduct(string $name, string $category, string $size, int $price, string $description, string $assetFile): void
    {
        $imagePath = null;

        if (file_exists($assetFile)) {
            $filename = Str::slug($name) . '-' . Str::random(6) . '.' . pathinfo($assetFile, PATHINFO_EXTENSION);
            $stored = Storage::disk('public')->putFileAs('products', new \Illuminate\Http\File($assetFile), $filename);
            $imagePath = $stored; // contoh: products/custom-t-shirt-abc123.jpg
        }

        Product::create([
            'name' => $name,
            'category' => $category,
            'size' => $size,
            'price' => $price,
            'description' => $description,
            'image_url' => $imagePath,
        ]);
    }
}

