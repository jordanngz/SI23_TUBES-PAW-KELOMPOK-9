<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BackendClient;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $response = BackendClient::request()->get(BackendClient::menuUrl('/api/products/latest'));
        $products = [];
        
        if ($response->successful()) {
            $products = Product::hydrate($response->json());
        }

        return view('user.home', compact('products'));
    }
}
