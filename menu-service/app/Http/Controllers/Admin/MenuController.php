<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function latest()
    {
        $products = Product::latest()->take(4)->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $product = Product::create($data);

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->only(['name', 'description', 'price']);

        if ($request->hasFile('image')) {
            $oldImage = public_path('images/'.$product->image);
            if ($product->image && file_exists($oldImage)) {
                @unlink($oldImage);
            }
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            $imagePath = public_path('images/' . $product->image);
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        $product->delete();

        return response()->json([
            'success' => true
        ]);
    }
}