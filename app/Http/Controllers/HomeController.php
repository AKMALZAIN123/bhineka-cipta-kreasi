<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function produk()
    {
        return view('produk');
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function kontak()
    {
        return view('kontak');
    }

    public function detail()
    {
        return view('detail');
    }

    // Protected routes
    public function cart()
    {
        return view('cart');
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