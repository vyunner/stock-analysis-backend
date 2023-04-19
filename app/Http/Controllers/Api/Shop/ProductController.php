<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return $this->response(Product::all(), 200);
    }

    public function store()
    {
        $product = Product::create(request()->validate([
            'name' => 'required|max:255',
            'price' => 'required|max:11',
            'product_amount' => 'required|max:11',
            'category_id' => 'required|max:11|exists:categories,id',
            'expiry_date' => 'nullable|date'
        ]));
        if (!$product) {
            return $this->response([], 500);
        }
        return $this->response($product, 200);
    }

    public function show(Product $product)
    {
        return $this->response($product);
    }

    public function update(Product $product)
    {
        $product->update(request()->validate([
            'name' => 'nullable|max:255',
            'price' => 'nullable|max:11',
            'product_amount' => 'nullable|max:11',
            'category_id' => 'nullable|max:11|exists:categories,id',
            'expiry_date' => 'nullable|date'
        ]));
        return $this->response($product, 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return $this->response([], 200);
    }
}
