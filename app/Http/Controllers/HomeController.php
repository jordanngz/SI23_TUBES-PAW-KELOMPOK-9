<?php

namespace App\Http\Controllers;
use App\Models\Product;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 produk terbaru atau best seller
        $products = Product::latest()->take(4)->get();
        return view('user.home', compact('products'));
    }
}
