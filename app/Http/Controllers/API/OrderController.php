<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Checkout - Create order from cart
     * POST /api/orders/checkout
     * Body: { alamat, no_telp }
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:15',
        ]);

        $user = $request->user();

        // Get user's cart
        $cart = Cart::where('user_id', $user->user_id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty',
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'user_id' => $user->user_id,
                'order_date' => now(),
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'total_amount' => $cart->total_price,
                'status' => 'pending',
            ]);

            // Create order items from cart items
            foreach ($cart->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'sub_total' => $cartItem->subtotal,
                ]);
            }

            // Clear cart after checkout
            $cart->cartItems()->delete();
            $cart->update(['total_price' => 0]);

            // Load order with items and products
            $order->load(['orderItems.product', 'user']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order_id' => $order->order_id,
                    'order_date' => $order->order_date->format('Y-m-d'),
                    'alamat' => $order->alamat,
                    'no_telp' => $order->no_telp,
                    'status' => $order->status,
                    'items' => $order->orderItems->map(function ($item) {
                        return [
                            'product' => [
                                'product_id' => $item->product->product_id,
                                'name' => $item->product->name,
                                'category' => $item->product->category,
                                'price' => $item->product->price,
                            ],
                            'quantity' => $item->quantity,
                            'sub_total' => $item->sub_total,
                        ];
                    }),
                    'total_amount' => $order->total_amount,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get order history
     * GET /api/orders
     * Query params: status, per_page
     */
    public function history(Request $request)
    {
        $user = $request->user();
        $perPage = $request->input('per_page', 10);
        $status = $request->input('status');

        $query = Order::where('user_id', $user->user_id)
            ->with(['orderItems.product']);

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->orderBy('order_date', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Order history retrieved successfully',
            'data' => $orders->map(function ($order) {
                return [
                    'order_id' => $order->order_id,
                    'order_date' => $order->order_date->format('Y-m-d'),
                    'status' => $order->status,
                    'total_items' => $order->orderItems->sum('quantity'),
                    'total_amount' => $order->total_amount,
                    'alamat' => $order->alamat,
                    'no_telp' => $order->no_telp,
                ];
            }),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
                'last_page' => $orders->lastPage(),
            ],
        ]);
    }

    /**
     * Get order detail
     * GET /api/orders/{orderId}
     */
    public function detail(Request $request, $orderId)
    {
        $user = $request->user();

        $order = Order::where('user_id', $user->user_id)
            ->where('order_id', $orderId)
            ->with(['orderItems.product', 'user'])
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order detail retrieved successfully',
            'data' => [
                'order_id' => $order->order_id,
                'order_date' => $order->order_date->format('Y-m-d'),
                'status' => $order->status,
                'customer' => [
                    'name' => $order->user->name,
                    'email' => $order->user->email,
                ],
                'shipping' => [
                    'alamat' => $order->alamat,
                    'no_telp' => $order->no_telp,
                ],
                'items' => $order->orderItems->map(function ($item) {
                    return [
                        'product_id' => $item->product->product_id,
                        'name' => $item->product->name,
                        'category' => $item->product->category,
                        'size' => $item->product->size,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                        'sub_total' => $item->sub_total,
                    ];
                }),
                'summary' => [
                    'total_items' => $order->orderItems->count(),
                    'total_quantity' => $order->orderItems->sum('quantity'),
                    'total_amount' => $order->total_amount,
                ],
                'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $order->updated_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * Cancel order
     * POST /api/orders/{orderId}/cancel
     */
    public function cancel(Request $request, $orderId)
    {
        $user = $request->user();

        $order = Order::where('user_id', $user->user_id)
            ->where('order_id', $orderId)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        // Only allow cancellation for pending and confirmed orders
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Order cannot be cancelled. Current status: ' . $order->status,
            ], 400);
        }

        DB::beginTransaction();
        try {
            $order->status = 'cancelled';
            $order->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully',
                'data' => [
                    'order_id' => $order->order_id,
                    'status' => $order->status,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}