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

        foreach ($orders as $order) {
            $product = Product::find($order->product_id);

            $order->product_name = $product->name;
            $order->product_price = $product->price;
            $order->product_amount = $product->product_amount;
        }

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
        return $this->response($order, 200);
    }

    public function show(Order $order)
    {
        return $this->response($order, 200);
    }

    public function update(Order $order)
    {
        $newOrder = request()->validate([
            'order_amount' => 'nullable|max:11',
        ]);
        Product::where('id', $order['product_id'])->deincrement('product_amount', $newOrder['order_amount'] - $order['order_amount']);
        $order->update($newOrder);

        return $this->response([$order], 200);
    }

    public function destroy(Order $order)
    {
        Product::where('id', $order['product_id'])->increment('product_amount', $order['order_amount']);
        $order->delete();
        return $this->response([], 200);
    }
}
