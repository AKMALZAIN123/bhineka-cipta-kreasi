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

    public function koleksi()
    {
        return view('koleksi');
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function kontak()
    {
        return view('kontak');
    }

    public function regis()
    {
        return view('regis');
    }
    

}
