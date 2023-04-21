<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\Uploads\UploadController;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\Uploads\UploadRequest;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use App\Services\UploadService\UploadService;

class ProductController extends Controller
{
    private $uploadService;

    public function __construct(UploadService $uploadService){
        $this->uploadService = $uploadService;
    }
    public function index()
    {
        $products = Product::all();
        foreach ($products as $product){
            $product->category_name = Category::where('id', $product['category_id'])->first()['name'];
            $product->files = $this->uploadService->get($product);
        }
        return $this->response($products, 200);
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
        $this->uploadService->delete($product);
        return $this->response([], 200);
    }

    public function uploadImage(UploadRequest $request, Product $product)
    {
        if($this->uploadService->store($request, $product)){
            return $this->response([], 200);
        }
        else {
            return $this->response([], 422);
        }
    }
}
