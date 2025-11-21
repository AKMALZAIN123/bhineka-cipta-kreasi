<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::first();
        $user2 = User::skip(1)->first();

        $product1 = Product::where('name', 'Custom T-Shirt')->first();
        $product2 = Product::where('name', 'Custom Mug')->first();
        $product3 = Product::where('name', 'Custom Hoodie')->first();
        $product4 = Product::where('name', 'Custom Tote Bag')->first();

        // Order 1
        $order1 = Order::create([
            'user_id' => $user1->user_id,
            'order_date' => now(),
            'alamat' => 'Jl. Sudirman No. 123, Jakarta Pusat, DKI Jakarta 10220',
            'no_telp' => '081234567890',
            'total_amount' => 225000,
            'status' => 'pending',
        ]);

        OrderItem::create([
            'order_id' => $order1->order_id,
            'product_id' => $product1->product_id,
            'quantity' => 1,
            'sub_total' => 150000,
        ]);

        OrderItem::create([
            'order_id' => $order1->order_id,
            'product_id' => $product2->product_id,
            'quantity' => 1,
            'sub_total' => 75000,
        ]);

        // Order 2
        $order2 = Order::create([
            'user_id' => $user2->user_id,
            'order_date' => now()->subDays(1),
            'alamat' => 'Jl. Gatot Subroto No. 45, Bandung, Jawa Barat 40262',
            'no_telp' => '082345678901',
            'total_amount' => 350000,
            'status' => 'confirmed',
        ]);

        OrderItem::create([
            'order_id' => $order2->order_id,
            'product_id' => $product3->product_id,
            'quantity' => 1,
            'sub_total' => 250000,
        ]);

        OrderItem::create([
            'order_id' => $order2->order_id,
            'product_id' => $product4->product_id,
            'quantity' => 1,
            'sub_total' => 100000,
        ]);

        // Order 3
        $order3 = Order::create([
            'user_id' => $user1->user_id,
            'order_date' => now()->subDays(3),
            'alamat' => 'Jl. Ahmad Yani No. 78, Surabaya, Jawa Timur 60234',
            'no_telp' => '081234567890',
            'total_amount' => 450000,
            'status' => 'completed',
        ]);

        OrderItem::create([
            'order_id' => $order3->order_id,
            'product_id' => $product1->product_id,
            'quantity' => 2,
            'sub_total' => 300000,
        ]);

        OrderItem::create([
            'order_id' => $order3->order_id,
            'product_id' => $product2->product_id,
            'quantity' => 2,
            'sub_total' => 150000,
        ]);

        // Order 4 - Multiple items
        $order4 = Order::create([
            'user_id' => $user2->user_id,
            'order_date' => now()->subDays(5),
            'alamat' => 'Jl. Diponegoro No. 99, Semarang, Jawa Tengah 50241',
            'no_telp' => '082345678901',
            'total_amount' => 825000,
            'status' => 'shipped',
        ]);

        OrderItem::create([
            'order_id' => $order4->order_id,
            'product_id' => $product3->product_id,
            'quantity' => 2,
            'sub_total' => 500000,
        ]);

        OrderItem::create([
            'order_id' => $order4->order_id,
            'product_id' => $product1->product_id,
            'quantity' => 1,
            'sub_total' => 150000,
        ]);

        OrderItem::create([
            'order_id' => $order4->order_id,
            'product_id' => $product2->product_id,
            'quantity' => 1,
            'sub_total' => 75000,
        ]);

        OrderItem::create([
            'order_id' => $order4->order_id,
            'product_id' => $product4->product_id,
            'quantity' => 1,
            'sub_total' => 100000,
        ]);

        // Order 5
        $order5 = Order::create([
            'user_id' => $user1->user_id,
            'order_date' => now()->subDays(7),
            'alamat' => 'Jl. Merdeka No. 12, Yogyakarta, DI Yogyakarta 55161',
            'no_telp' => '081234567890',
            'total_amount' => 500000,
            'status' => 'delivered',
        ]);

        OrderItem::create([
            'order_id' => $order5->order_id,
            'product_id' => $product3->product_id,
            'quantity' => 2,
            'sub_total' => 500000,
        ]);
    }
}
