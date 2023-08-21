<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
        ]);
        $product = new Product($validatedData);
        if ($product->save()){
            return response()->json(['success' => true], 201);
        } else {
            return response()->json(['success' => false], 500);
        }
    }

    public function delete(int $id)
    {
        $product = Product::find($id);
        if ($product && $product->delete()) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], $product ? 500 : 404);
        }
    }

    public function update(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required|numeric',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
        ]);

        $product = Product::find($validatedData['id']);
        if ($product && $product->update([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
            ])) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], $product ? 500 : 404);
        }
    }
}
