<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BackendClient;

class MenuController extends Controller
{
    public function index()
    {
        $response = BackendClient::request()->get(BackendClient::menuUrl('/api/products'));
        $products = [];
        if ($response->successful()) {
            $products = Product::hydrate($response->json());
        }
        return view('admin.menuadmin', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $client = BackendClient::request();

        // Attach image if present
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $client = $client->attach(
                'image',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            );
        }

        $response = $client->post(BackendClient::menuUrl('/api/products'), $request->only(['name', 'description', 'price']));

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('admin.menu.management')->with('success', 'Menu added!');
        }

        return back()->with('error', 'Failed to add menu.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $client = BackendClient::request();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $client = $client->attach(
                'image',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            );
        }

        // We can use POST to downstream if PUT doesn't support multipart, or use PUT with form fields. 
        // Wait, standard HTTP clients support multipart with PUT, but POST with _method=PUT is safer!
        $data = $request->only(['name', 'description', 'price']);
        $data['_method'] = 'PUT';

        $response = $client->post(BackendClient::menuUrl("/api/products/{$id}"), $data);

        if ($response->successful()) {
            return redirect()->route('admin.menu.management')->with('success', 'Menu updated!');
        }

        return back()->with('error', 'Failed to update menu.');
    }

    public function destroy($id)
    {
        $response = BackendClient::request()->delete(BackendClient::menuUrl("/api/products/{$id}"));

        if ($response->successful()) {
            return redirect()->route('admin.menu.management')->with('success', 'Menu deleted!');
        }

        return back()->with('error', 'Failed to delete menu.');
    }
}