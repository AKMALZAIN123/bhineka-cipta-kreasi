<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaymentController;

class OrderController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout()
    {
        $user = Auth::user();
        
        $cart = Cart::with(['cartItems.product'])
            ->where('user_id', $user->user_id)
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong');
        }

        $subtotal = 0;
        foreach ($cart->cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        $shippingCost = 10000;
        $total = $subtotal + $shippingCost;

        return view('checkout', compact('cart', 'user', 'subtotal', 'shippingCost', 'total'));
    }

    /**
     * Process checkout and create order
     */
    public function processCheckout(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email',
                'address' => 'required|string',
                'district' => 'required|string|max:100',
                'city' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'postal_code' => 'required|string|max:10',
                'address_notes' => 'nullable|string|max:500',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error: ' . json_encode($e->errors()));
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            DB::beginTransaction();

            $user = Auth::user();
            Log::info('Checkout - User ID: ' . $user->user_id);

            // Get cart
            $cart = Cart::with(['cartItems.product'])
                ->where('user_id', $user->user_id)
                ->first();

            if (!$cart || $cart->cartItems->isEmpty()) {
                throw new \Exception('Keranjang tidak ditemukan atau kosong');
            }

            Log::info('Checkout - Cart items count: ' . $cart->cartItems->count());

            // Calculate total
            $subtotal = 0;
            foreach ($cart->cartItems as $item) {
                if (!$item->product) {
                    throw new \Exception('Produk tidak ditemukan untuk item cart ID: ' . $item->cart_item_id);
                }
                $subtotal += $item->product->price * $item->quantity;
            }
            $shippingCost = 10000;
            $totalAmount = $subtotal + $shippingCost;

            Log::info('Checkout - Total amount: ' . $totalAmount);

            // Create Order
            $order = Order::create([
                'user_id' => $user->user_id,
                'order_date' => now(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'nama_lengkap' => $validated['name'],
                'nomor_telepon' => $validated['phone'],
                'email' => $validated['email'],
                'alamat_lengkap' => $validated['address'],
                'kecamatan' => $validated['district'],
                'kabupaten_kota' => $validated['city'],
                'provinsi' => $validated['province'],
                'kode_pos' => $validated['postal_code'],
                'catatan_pengiriman' => $validated['address_notes'] ?? null,
            ]);

            Log::info('Checkout - Order created: ' . $order->order_id);

            // Create Order Items
            foreach ($cart->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'sub_total' => $item->product->price * $item->quantity,
                ]);
            }

            Log::info('Checkout - Order items created');

            // Generate Midtrans Snap Token
            Log::info('Checkout - Generating Snap Token');
            
            try {
                $paymentController = new PaymentController();
                $snapToken = $paymentController->generateSnapToken($order, $validated);
                
                Log::info('Checkout - Snap Token generated successfully');
            } catch (\Exception $e) {
                Log::error('Snap Token Generation Failed: ' . $e->getMessage());
                throw new \Exception('Gagal membuat token pembayaran: ' . $e->getMessage());
            }

            // Create Payment Record with snap_token
            $payment = \App\Models\Payment::create([
                'order_id' => $order->order_id,
                'method' => 'midtrans',
                'snap_token' => $snapToken,
                'amount' => $totalAmount,
                'status' => 'pending',
            ]);

            Log::info('Checkout - Payment created: ' . $payment->payment_id);

            // Delete cart items after successful order
            $deletedCount = $cart->cartItems()->delete();
            Log::info('Checkout - Cart items deleted: ' . $deletedCount);

            DB::commit();

            // Return JSON for AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order berhasil dibuat',
                    'order_id' => $order->order_id,
                    'snap_token' => $snapToken,
                ]);
            }

            // If not AJAX, redirect to payment page
            return view('payment', compact('order', 'snapToken', 'payment'));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            Log::error('Checkout error file: ' . $e->getFile() . ' line: ' . $e->getLine());
            Log::error('Checkout error trace: ' . $e->getTraceAsString());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.',
                    'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                ], 500);
            }
            
            return redirect()->route('cart')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Order success page (after payment)
     */
    public function orderSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        
        if (!$orderId) {
            return redirect()->route('home');
        }

        $order = Order::with(['orderItems.product', 'payment'])
            ->where('order_id', $orderId)
            ->where('user_id', Auth::user()->user_id)
            ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan');
        }

        return view('order-success', compact('order'));
    }

    /**
     * Order pending page (when payment is pending)
     */
    public function orderPending(Request $request)
    {
        $orderId = $request->query('order_id');
        
        if (!$orderId) {
            return redirect()->route('home');
        }

        $order = Order::with(['orderItems.product', 'payment'])
            ->where('order_id', $orderId)
            ->where('user_id', Auth::user()->user_id)
            ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan');
        }

        return view('order-pending', compact('order'));
    }

    /**
     * Order error page (when payment failed)
     */
    public function orderError(Request $request)
    {
        $orderId = $request->query('order_id');
        
        if (!$orderId) {
            return redirect()->route('home');
        }

        $order = Order::with(['orderItems.product', 'payment'])
            ->where('order_id', $orderId)
            ->where('user_id', Auth::user()->user_id)
            ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan');
        }

        return view('order-error', compact('order'));
    }

    /**
     * Show user's order history
     */
    public function orders()
    {
        $user = Auth::user();
        
        $orders = Order::with(['orderItems.product', 'payment'])
            ->where('user_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders', compact('orders'));
    }

    /**
     * Show order detail
     */
    public function orderDetail($orderId)
    {
        $order = Order::with(['orderItems.product', 'payment'])
            ->where('order_id', $orderId)
            ->where('user_id', Auth::user()->user_id)
            ->first();

        if (!$order) {
            return redirect()->route('orders')->with('error', 'Pesanan tidak ditemukan');
        }

        return view('order-detail', compact('order'));
    }
}