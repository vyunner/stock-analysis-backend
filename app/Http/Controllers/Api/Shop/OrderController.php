<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return $this->response($orders, 200);
    }

    public function store()
    {
        $order = Order::create(request()->validate([
            'order_amount' => 'required|max:11',
            'product_id' => 'required|max:11|exists:products,id'
        ]));
        if (!$order) {
            return $this->response([], 500);
        }
        Product::where('id', $order['product_id'])->decrement('product_amount', $order['order_amount']);
            return $this->response([], 200);
    }

    public function show(Order $order)
    {
        return $this->response($order, 200);
    }

    public function update(Order $order)
    {

    }

    public function destroy(Order $order)
    {

    }
}
