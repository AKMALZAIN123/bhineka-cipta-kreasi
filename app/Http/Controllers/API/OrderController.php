<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Helpers\ApiResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Checkout - Create order from cart
     * POST /api/orders/checkout
     * Body: { alamat, no_telp }
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkout(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'alamat' => 'required|string|max:500',
                'no_telp' => 'required|string|max:15',
            ]);

            $user = $request->user();

            // Get user's cart
            $cart = Cart::where('user_id', $user->user_id)->first();

            if (!$cart || $cart->cartItems->isEmpty()) {
                return ApiResponseHelper::error('Cart is empty', 400);
            }

            DB::beginTransaction();

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

            $data = [
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
            ];

            return ApiResponseHelper::success($data, 'Order created successfully', 201);

        } catch (ValidationException $e) {
            return ApiResponseHelper::validationError(
                $e->errors(),
                'Invalid checkout data'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::serverError(
                'Failed to create order',
                $e->getMessage()
            );
        }
    }

    /**
     * Get order history
     * GET /api/orders
     * Query params: status, per_page
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function history(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'status' => 'nullable|in:pending,confirmed,processing,shipped,delivered,cancelled',
                'per_page' => 'nullable|integer|min:1|max:100',
            ]);

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

            // Transform data
            $transformedOrders = $orders->getCollection()->map(function ($order) {
                return [
                    'order_id' => $order->order_id,
                    'order_date' => $order->order_date->format('Y-m-d'),
                    'status' => $order->status,
                    'total_items' => $order->orderItems->sum('quantity'),
                    'total_amount' => $order->total_amount,
                    'alamat' => $order->alamat,
                    'no_telp' => $order->no_telp,
                ];
            });

            $orders->setCollection($transformedOrders);

            return ApiResponseHelper::successWithPagination(
                $orders,
                'Order history retrieved successfully'
            );

        } catch (ValidationException $e) {
            return ApiResponseHelper::validationError(
                $e->errors(),
                'Invalid filter parameters'
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::serverError(
                'Failed to retrieve order history',
                $e->getMessage()
            );
        }
    }

    /**
     * Get order detail
     * GET /api/orders/{orderId}
     *
     * @param Request $request
     * @param int $orderId
     * @return JsonResponse
     */
    public function detail(Request $request, int $orderId): JsonResponse
    {
        try {
            $user = $request->user();

            $order = Order::where('user_id', $user->user_id)
                ->where('order_id', $orderId)
                ->with(['orderItems.product', 'user'])
                ->first();

            if (!$order) {
                return ApiResponseHelper::notFound('Order not found');
            }

            $data = [
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
            ];

            return ApiResponseHelper::success($data, 'Order detail retrieved successfully');

        } catch (\Exception $e) {
            return ApiResponseHelper::serverError(
                'Failed to retrieve order detail',
                $e->getMessage()
            );
        }
    }

    /**
     * Cancel order
     * POST /api/orders/{orderId}/cancel
     *
     * @param Request $request
     * @param int $orderId
     * @return JsonResponse
     */
    public function cancel(Request $request, int $orderId): JsonResponse
    {
        try {
            $user = $request->user();

            $order = Order::where('user_id', $user->user_id)
                ->where('order_id', $orderId)
                ->first();

            if (!$order) {
                return ApiResponseHelper::notFound('Order not found');
            }

            // Only allow cancellation for pending and confirmed orders
            if (!in_array($order->status, ['pending', 'confirmed'])) {
                return ApiResponseHelper::error(
                    'Order cannot be cancelled. Current status: ' . $order->status,
                    400
                );
            }

            DB::beginTransaction();

            $order->status = 'cancelled';
            $order->save();

            DB::commit();

            $data = [
                'order_id' => $order->order_id,
                'status' => $order->status,
                'cancelled_at' => now()->format('Y-m-d H:i:s'),
            ];

            return ApiResponseHelper::success($data, 'Order cancelled successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::serverError(
                'Failed to cancel order',
                $e->getMessage()
            );
        }
    }

    /**
     * Get order by ID (alias for detail)
     * GET /api/orders/show/{orderId}
     *
     * @param Request $request
     * @param int $orderId
     * @return JsonResponse
     */
    public function show(Request $request, int $orderId): JsonResponse
    {
        return $this->detail($request, $orderId);
    }
}