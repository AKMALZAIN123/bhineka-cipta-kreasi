<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    /**
     * Generate Snap Token for payment
     * 
     * @param Order $order
     * @param array $shippingInfo
     * @return string
     */
    public function generateSnapToken($order, $shippingInfo = [])
    {
        try {
            // Load order items if not loaded
            if (!$order->relationLoaded('orderItems')) {
                $order->load('orderItems.product');
            }

            // Transaction details
            $transactionDetails = [
                'order_id' => 'ORDER-' . $order->order_id . '-' . time(),
                'gross_amount' => (int) $order->total_amount,
            ];

            // Item details
            $itemDetails = [];
            $calculatedTotal = 0;

            foreach ($order->orderItems as $item) {
                if (!$item->product) {
                    Log::error('Product not found for OrderItem ID: ' . $item->id);
                    continue;
                }

                $itemPrice = (int) ($item->sub_total / $item->quantity);
                $itemDetails[] = [
                    'id' => $item->product_id,
                    'price' => $itemPrice,
                    'quantity' => $item->quantity,
                    'name' => substr($item->product->name, 0, 50), // Midtrans limit 50 chars
                ];
                $calculatedTotal += $itemPrice * $item->quantity;
            }

            // Add shipping cost
            $shippingPrice = 10000;
            $itemDetails[] = [
                'id' => 'SHIPPING',
                'price' => $shippingPrice,
                'quantity' => 1,
                'name' => 'Biaya Pengiriman',
            ];
            $calculatedTotal += $shippingPrice;

            // Verify total matches
            if ($calculatedTotal != (int) $order->total_amount) {
                Log::warning('Order total mismatch. Calculated: ' . $calculatedTotal . ', Order: ' . $order->total_amount);
            }

            // Customer details
            $customerDetails = [
                'first_name' => $shippingInfo['name'] ?? $order->nama_lengkap ?? 'Customer',
                'email' => $shippingInfo['email'] ?? $order->email ?? '',
                'phone' => $shippingInfo['phone'] ?? $order->nomor_telepon ?? '',
                'billing_address' => [
                    'first_name' => $shippingInfo['name'] ?? $order->nama_lengkap ?? 'Customer',
                    'phone' => $shippingInfo['phone'] ?? $order->nomor_telepon ?? '',
                    'address' => $order->alamat_lengkap ?? '',
                    'city' => $order->kabupaten_kota ?? '',
                    'postal_code' => $order->kode_pos ?? '',
                ],
                'shipping_address' => [
                    'first_name' => $order->nama_lengkap ?? 'Customer',
                    'phone' => $order->nomor_telepon ?? '',
                    'address' => $order->alamat_lengkap ?? '',
                    'city' => $order->kabupaten_kota ?? '',
                    'postal_code' => $order->kode_pos ?? '',
                ],
            ];

            // Transaction parameters
            $params = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $itemDetails,
                'enabled_payments' => [
                    'credit_card', 'bca_va', 'bni_va', 'bri_va', 
                    'permata_va', 'other_va', 'gopay', 'shopeepay', 
                    'qris', 'cimb_clicks', 'danamon_online'
                ],
            ];

            Log::info('Midtrans Params: ' . json_encode($params));

            // Get Snap Token
            $snapToken = Snap::getSnapToken($params);

            Log::info('Snap Token Generated: ' . substr($snapToken, 0, 20) . '...');

            return $snapToken;

        } catch (\Exception $e) {
            Log::error('Snap Token Generation Error: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            throw new \Exception('Gagal membuat token pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Handle Midtrans notification callback
     */
    public function handleNotification(Request $request)
    {
        try {
            Log::info("Webhook RAW: ".$request->getContent());

            $notification = json_decode($request->getContent());

            if (!$notification) {
                return response()->json(['status' => 'error', 'message' => 'Invalid JSON'], 400);
            }

            // Extract order_id from: ORDER-{id}-{timestamp}
            if (!preg_match('/^ORDER-(\d+)-/', $notification->order_id, $matches)) {
                Log::error("Invalid Midtrans order format: ".$notification->order_id);
                return response()->json(['status' => 'error', 'message' => 'Invalid order id'], 400);
            }

            $realOrderId = intval($matches[1]);
            Log::info("Extracted Real Order ID: ".$realOrderId);

            // Find order by order_id
            $order = Order::where('order_id', $realOrderId)->first();

            if (!$order) {
                Log::error("Order not found: ".$realOrderId);
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            $payment = Payment::where('order_id', $order->order_id)->first();

            // Determine payment status
            $status = $notification->transaction_status;

            if ($status === 'settlement') {
                $this->updatePaymentStatus($order, $payment, 'success', $notification);
            } elseif ($status === 'pending') {
                $this->updatePaymentStatus($order, $payment, 'pending', $notification);
            } elseif (in_array($status, ['deny', 'expire', 'cancel'])) {
                $this->updatePaymentStatus($order, $payment, 'failed', $notification);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error("Webhook error: ".$e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * Update payment and order status
     */
    private function updatePaymentStatus($order, $payment, $status, $notification)
    {
        // Update payment status
        if ($payment) {
            $payment->update([
                'status' => $status,
                'method' => $notification->payment_type ?? $payment->method,
            ]);
        }

        // Update order status based on payment status
        $orderStatus = $status;
        if ($status === 'success') {
            $orderStatus = 'paid';
        } elseif ($status === 'pending') {
            $orderStatus = 'pending';
        } elseif (in_array($status, ['failed', 'cancelled', 'expired'])) {
            $orderStatus = 'cancelled';
        }

        $order->update(['status' => $orderStatus]);

        Log::info("Order #{$order->order_id} status updated to {$orderStatus}");
    }

    /**
     * Check payment status (for frontend polling)
     */
    public function checkStatus($orderId)
    {
        try {
            $order = Order::with('payment')->find($orderId);

            if (!$order) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Order not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'order_status' => $order->status,
                'payment_status' => $order->payment->status ?? 'pending',
            ]);
        } catch (\Exception $e) {
            Log::error('Check status error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}