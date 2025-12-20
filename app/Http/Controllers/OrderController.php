<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Payment;
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
   public function checkout(Request $request)
    {
        $user = Auth::user();
        $shippingCost = 10000;

        $mode = $request->query('mode', 'cart'); 

        if ($mode === 'buy_now') {
            $buyNow = session('buy_now');

            if (!$buyNow) {
                return redirect()->route('produk')->with('error', 'Sesi Buy Now sudah habis. Silakan pilih produk lagi.');
            }

            $product = Product::findOrFail($buyNow['product_id']);

            if (($product->availability ?? 'available') !== 'available') {
                session()->forget('buy_now');
                return redirect()->route('produk')->with('error', 'Produk tidak tersedia');
            }

            $quantity = max(1, (int) $buyNow['quantity']);
            $subtotal = $product->price * $quantity;
            $total    = $subtotal + $shippingCost;

            return view('checkout', [
                'user'         => $user,
                'mode'         => 'buy_now',
                'product'      => $product,
                'quantity'     => $quantity,
                'subtotal'     => $subtotal,
                'shippingCost' => $shippingCost,
                'total'        => $total,
            ]);
        }

        session()->forget('buy_now');

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

        $total = $subtotal + $shippingCost;

        return view('checkout', [
            'cart'         => $cart,
            'user'         => $user,
            'mode'         => 'cart',
            'subtotal'     => $subtotal,
            'shippingCost' => $shippingCost,
            'total'        => $total,
        ]);
    }

    public function buyNow(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($data['product_id']);

        if (($product->availability ?? 'available') !== 'available') {
            return back()->with('error', 'Produk tidak tersedia');
        }

        session([
            'buy_now' => [
                'product_id' => $product->product_id,
                'quantity'   => (int) $data['quantity'],
            ]
        ]);

        return redirect()->route('checkout', ['mode' => 'buy_now']);
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
                'mode' => 'nullable|in:cart,buy_now', // ✅
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
            $mode = $validated['mode'] ?? 'cart';
            Log::info("Checkout - User ID: {$user->user_id} | Mode: {$mode}");

            $shippingCost = 10000;

            $itemsForOrder = [];

            if ($mode === 'buy_now') {
                $buyNow = session('buy_now');

                if (!$buyNow || empty($buyNow['product_id']) || empty($buyNow['quantity'])) {
                    throw new \Exception('Sesi Buy Now tidak ditemukan / sudah kadaluarsa');
                }

                $product = Product::findOrFail($buyNow['product_id']);

                if (($product->availability ?? 'available') !== 'available') {
                    session()->forget('buy_now');
                    throw new \Exception('Produk tidak tersedia');
                }

                $qty = (int) $buyNow['quantity'];
                if ($qty < 1) $qty = 1;

                $itemsForOrder[] = [
                    'product' => $product,
                    'quantity' => $qty,
                ];

                Log::info('Checkout - BuyNow item: product_id=' . $product->product_id . ' qty=' . $qty);

            } else {
                $cart = Cart::with(['cartItems.product'])
                    ->where('user_id', $user->user_id)
                    ->first();

                if (!$cart || $cart->cartItems->isEmpty()) {
                    throw new \Exception('Keranjang tidak ditemukan atau kosong');
                }

                Log::info('Checkout - Cart items count: ' . $cart->cartItems->count());

                foreach ($cart->cartItems as $item) {
                    if (!$item->product) {
                        throw new \Exception('Produk tidak ditemukan untuk item cart ID: ' . ($item->cart_item_id ?? '-'));
                    }

                    if (($item->product->availability ?? 'available') !== 'available') {
                        throw new \Exception('Ada produk di keranjang yang tidak tersedia: ' . $item->product->name);
                    }

                    $itemsForOrder[] = [
                        'product' => $item->product,
                        'quantity' => (int) $item->quantity,
                    ];
                }
            }

            $subtotal = 0;
            foreach ($itemsForOrder as $row) {
                $subtotal += $row['product']->price * $row['quantity'];
            }
            $totalAmount = $subtotal + $shippingCost;

            Log::info('Checkout - Total amount: ' . $totalAmount);

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

            foreach ($itemsForOrder as $row) {
                $product = $row['product'];
                $qty = $row['quantity'];

                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $product->product_id,
                    'quantity' => $qty,
                    'sub_total' => $product->price * $qty,
                ]);
            }

            Log::info('Checkout - Order items created');

            Log::info('Checkout - Generating Snap Token');

            try {
                $paymentController = new PaymentController();
                $snapToken = $paymentController->generateSnapToken($order, $validated);

                Log::info('Checkout - Snap Token generated successfully');
            } catch (\Exception $e) {
                Log::error('Snap Token Generation Failed: ' . $e->getMessage());
                throw new \Exception('Gagal membuat token pembayaran: ' . $e->getMessage());
            }

            $payment = Payment::create([
                'order_id' => $order->order_id,
                'method' => 'midtrans',
                'snap_token' => $snapToken,
                'amount' => $totalAmount,
                'status' => 'pending',
            ]);

            Log::info('Checkout - Payment created: ' . $payment->payment_id);

            if ($mode === 'cart') {
                $cart = $cart ?? Cart::where('user_id', $user->user_id)->first();
                if ($cart) {
                    $deletedCount = $cart->cartItems()->delete();
                    Log::info('Checkout - Cart items deleted: ' . $deletedCount);
                }
            } else {
                session()->forget('buy_now');
                Log::info('Checkout - buy_now session cleared');
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order berhasil dibuat',
                    'order_id' => $order->order_id,
                    'snap_token' => $snapToken,
                ]);
            }

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
        if (!$orderId) return redirect()->route('home');

        $order = Order::with(['orderItems.product', 'payment'])
            ->where('order_id', $orderId)
            ->where('user_id', Auth::user()->user_id)
            ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan');
        }

        if ($order->status === 'paid') {
            return redirect()->route('order.success', ['order_id' => $order->order_id]);
        }

        if (in_array($order->status, ['cancelled', 'failed'])) {
            return redirect()->route('order.error', ['order_id' => $order->order_id]);
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

    public function checkStatus(Order $order)
    {
        return response()->json([
            'status' => $order->status
        ]);
    }

}