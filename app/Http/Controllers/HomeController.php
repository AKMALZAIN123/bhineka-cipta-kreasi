<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $product = Product::findOrFail($id);

        return view('detail', compact('product'));
    }

    public function produk(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);
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
}