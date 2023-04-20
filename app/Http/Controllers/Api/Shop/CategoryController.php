<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return $this->response(Category::all());
    }

    public function store()
    {
        $category = Category::create(request()->validate([
            'name' => 'required|max:255'
        ]));
        if (!$category) {
            return $this->response([], 500);
        }
        return $this->response($category, 200);
    }

    public function show(Category $category)
    {
        return $this->response($category);
    }

    public function update(Category $category)
    {
        $category->update(request()->validate([
            'name' => 'nullable|max:255'
        ]));
        return $this->response($category, 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->response([], 200);
    }
}
