<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Helpers\ApiResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    /**
     * Get user's cart
     * GET /api/cart
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
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

            $data = [
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
            ];

            return ApiResponseHelper::success($data, 'Cart retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponseHelper::serverError(
                'Failed to retrieve cart',
                $e->getMessage()
            );
        }
    }

    /**
     * Add product to cart
     * POST /api/cart/add
     * Body: { product_id, quantity }
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,product_id',
                'quantity' => 'required|integer|min:1',
            ]);

            $user = $request->user();
            $product = Product::find($request->product_id);

            if (!$product) {
                return ApiResponseHelper::notFound('Product not found');
            }

            DB::beginTransaction();

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

            $data = [
                'item_id' => $cartItem->item_id,
                'product' => [
                    'product_id' => $product->product_id,
                    'name' => $product->name,
                    'price' => $product->price,
                ],
                'quantity' => $cartItem->quantity,
                'subtotal' => $cartItem->subtotal,
                'cart_total' => $cart->total_price,
            ];

            return ApiResponseHelper::success($data, 'Product added to cart successfully', 201);

        } catch (ValidationException $e) {
            return ApiResponseHelper::validationError(
                $e->errors(),
                'Invalid cart data'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::serverError(
                'Failed to add product to cart',
                $e->getMessage()
            );
        }
    }

    /**
     * Update cart item quantity
     * PUT /api/cart/update/{itemId}
     * Body: { quantity }
     *
     * @param Request $request
     * @param int $itemId
     * @return JsonResponse
     */
    public function update(Request $request, int $itemId): JsonResponse
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            $user = $request->user();

            $cartItem = CartItem::whereHas('cart', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })->find($itemId);

            if (!$cartItem) {
                return ApiResponseHelper::notFound('Cart item not found');
            }

            DB::beginTransaction();

            $product = $cartItem->product;
            $cartItem->quantity = $request->quantity;
            $cartItem->subtotal = $cartItem->quantity * $product->price;
            $cartItem->save();

            // Update cart total
            $cart = $cartItem->cart;
            $cart->total_price = $cart->cartItems()->sum('subtotal');
            $cart->save();

            DB::commit();

            $data = [
                'item_id' => $cartItem->item_id,
                'quantity' => $cartItem->quantity,
                'subtotal' => $cartItem->subtotal,
                'cart_total' => $cart->total_price,
            ];

            return ApiResponseHelper::success($data, 'Cart item updated successfully');

        } catch (ValidationException $e) {
            return ApiResponseHelper::validationError(
                $e->errors(),
                'Invalid quantity'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::serverError(
                'Failed to update cart item',
                $e->getMessage()
            );
        }
    }

    /**
     * Remove item from cart
     * DELETE /api/cart/remove/{itemId}
     *
     * @param Request $request
     * @param int $itemId
     * @return JsonResponse
     */
    public function remove(Request $request, int $itemId): JsonResponse
    {
        try {
            $user = $request->user();

            $cartItem = CartItem::whereHas('cart', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })->find($itemId);

            if (!$cartItem) {
                return ApiResponseHelper::notFound('Cart item not found');
            }

            DB::beginTransaction();

            $cart = $cartItem->cart;
            $cartItem->delete();

            // Update cart total
            $cart->total_price = $cart->cartItems()->sum('subtotal');
            $cart->save();

            DB::commit();

            $data = [
                'cart_total' => $cart->total_price,
                'total_items' => $cart->cartItems->count(),
            ];

            return ApiResponseHelper::success($data, 'Item removed from cart successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::serverError(
                'Failed to remove item from cart',
                $e->getMessage()
            );
        }
    }

    /**
     * Clear all items from cart
     * DELETE /api/cart/clear
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function clear(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $cart = Cart::where('user_id', $user->user_id)->first();

            if (!$cart) {
                return ApiResponseHelper::notFound('Cart not found');
            }

            DB::beginTransaction();

            $cart->cartItems()->delete();
            $cart->total_price = 0;
            $cart->save();

            DB::commit();

            return ApiResponseHelper::success(null, 'Cart cleared successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::serverError(
                'Failed to clear cart',
                $e->getMessage()
            );
        }
    }
}