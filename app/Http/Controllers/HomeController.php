<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()
            ->take(6) 
            ->get();

        return view('home', compact('products'));
    }

    public function detail($id)
    {
        $product = Product::withSum('orderItems as sold', 'quantity')
            ->findOrFail($id);

        return view('detail', compact('product'));
    }

    public function produk(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $sort = $request->get('sort', 'default');
        
        switch ($sort) {
            case 'popular':
                $query->withSum('orderItems', 'quantity')
                  ->orderByDesc('order_items_sum_quantity');
                break;
                
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
                
            case 'price-low':
                $query->orderBy('price', 'asc');
                break;
                
            case 'price-high':
                $query->orderBy('price', 'desc');
                break;
                
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
                
            case 'name-desc':
                $query->orderBy('name', 'desc');
                break;
                
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);
        
        $products->appends($request->all());
        
        return view('produk', compact('products'));
    }


    public function tentang()
    {
        return view('tentang');
    }

    public function kontak()
    {
        return view('kontak');
    }

    public function privasi()
    {
        return view('privasi');
    }

    public function syarat()
    {
        return view('syarat');
    }

    public function faq()
    {
        return view('faq');
    }

    public function profile()
    {
        return view('profile');
    }

    // Protected routes
    public function cart()
    {
        $user = auth()->user();

        $cart = Cart::with(['cartItems.product'])
                ->where('user_id', $user->user_id)
                ->first();

        return view('cart', [
            'cart' => $cart,
            'items' => $cart ? $cart->cartItems : collect()
        ]);
    }

    public function dashboard()
    {
        return redirect()->route('home');
    }


    public function orders()
    {
        return view('orders');
    }

    public function history()
    {
        $user = auth()->user();

        $orders = Order::with(['orderItems.product', 'payment'])
            ->where('user_id', $user->user_id) 
            ->orderByDesc('order_date')       
            ->paginate(10);

        return view('history', compact('orders'));
    }

    public function detailHistory(Order $order)
    {
        $user = auth()->user();

        if ($order->user_id !== $user->user_id) {
            abort(403, 'Unauthorized access');
        }

        $order->load([
            'orderItems.product',
            'payment'
        ]);

        return view('detail-history', compact('order'));
    }
}