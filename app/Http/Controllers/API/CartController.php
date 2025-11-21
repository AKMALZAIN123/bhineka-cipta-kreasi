<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Get user's cart
     * GET /api/cart
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get or create cart for user
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->user_id],
            ['total_price' => 0]
        );

        // Load cart items with product details
        $cart->load(['cartItems.product']);

        // Calculate total
        $totalPrice = $cart->cartItems->sum('subtotal');
        $cart->update(['total_price' => $totalPrice]);

        return response()->json([
            'success' => true,
            'message' => 'Cart retrieved successfully',
            'data' => [
                'cart_id' => $cart->cart_id,
                'items' => $cart->cartItems->map(function ($item) {
                    return [
                        'item_id' => $item->item_id,
                        'product' => [
                            'product_id' => $item->product->product_id,
                            'name' => $item->product->name,
                            'category' => $item->product->category,
                            'size' => $item->product->size,
                            'price' => $item->product->price,
                            'description' => $item->product->description,
                        ],
                        'quantity' => $item->quantity,
                        'subtotal' => $item->subtotal,
                    ];
                }),
                'total_items' => $cart->cartItems->count(),
                'total_quantity' => $cart->cartItems->sum('quantity'),
                'total_price' => $totalPrice,
            ],
        ]);
    }

    /**
     * Add product to cart
     * POST /api/cart/add
     * Body: { product_id, quantity }
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        DB::beginTransaction();
        try {
            // Get or create cart
            $cart = Cart::firstOrCreate(
                ['user_id' => $user->user_id],
                ['total_price' => 0]
            );

            // Check if product already in cart
            $cartItem = CartItem::where('cart_id', $cart->cart_id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($cartItem) {
                // Update existing item
                $cartItem->quantity += $request->quantity;
                $cartItem->subtotal = $cartItem->quantity * $product->price;
                $cartItem->save();
            } else {
                // Create new item
                $cartItem = CartItem::create([
                    'cart_id' => $cart->cart_id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'subtotal' => $request->quantity * $product->price,
                ]);
            }

            // Update cart total
            $cart->total_price = $cart->cartItems()->sum('subtotal');
            $cart->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'data' => [
                    'item_id' => $cartItem->item_id,
                    'product' => [
                        'product_id' => $product->product_id,
                        'name' => $product->name,
                        'price' => $product->price,
                    ],
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->subtotal,
                    'cart_total' => $cart->total_price,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update cart item quantity
     * PUT /api/cart/update/{itemId}
     * Body: { quantity }
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();

        $cartItem = CartItem::whereHas('cart', function ($query) use ($user) {
            $query->where('user_id', $user->user_id);
        })->find($itemId);

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        DB::beginTransaction();
        try {
            $product = $cartItem->product;
            $cartItem->quantity = $request->quantity;
            $cartItem->subtotal = $cartItem->quantity * $product->price;
            $cartItem->save();

            // Update cart total
            $cart = $cartItem->cart;
            $cart->total_price = $cart->cartItems()->sum('subtotal');
            $cart->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cart item updated successfully',
                'data' => [
                    'item_id' => $cartItem->item_id,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->subtotal,
                    'cart_total' => $cart->total_price,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove item from cart
     * DELETE /api/cart/remove/{itemId}
     */
    public function remove(Request $request, $itemId)
    {
        $user = $request->user();

        $cartItem = CartItem::whereHas('cart', function ($query) use ($user) {
            $query->where('user_id', $user->user_id);
        })->find($itemId);

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        DB::beginTransaction();
        try {
            $cart = $cartItem->cart;
            $cartItem->delete();

            // Update cart total
            $cart->total_price = $cart->cartItems()->sum('subtotal');
            $cart->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully',
                'data' => [
                    'cart_total' => $cart->total_price,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from cart',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Clear all items from cart
     * DELETE /api/cart/clear
     */
    public function clear(Request $request)
    {
        $user = $request->user();

        $cart = Cart::where('user_id', $user->user_id)->first();

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found',
            ], 404);
        }

        DB::beginTransaction();
        try {
            $cart->cartItems()->delete();
            $cart->total_price = 0;
            $cart->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}