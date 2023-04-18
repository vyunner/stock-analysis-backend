<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return $this->response($products, 200);
    }
    public function store(){
        $products = Product::create(request()->validate([
            'name' => 'required|max:255',
            'price' => 'required|max:11',
            'product_amount' => 'required|max:11',
            'category_id' => 'required|max:11|exists:categories,id',
            'expiry_date' => 'nullable|date'
        ]));
        if (!$products) {
            return $this->response([], 500);
        }
        return $this->response([], 200);
    }
    public function show(Product $product){

    }
    public function update(Product $product){

    }
    public function destroy(Product $product){

    }
}
