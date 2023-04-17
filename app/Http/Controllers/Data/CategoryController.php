<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return $this->response($categories, 200);
    }

    public function store()
    {
        $category = Category::create(request()->validate([
            'name' => 'required|max:255'
        ]));
        if (!$category) {
            return $this->response([], 500);
        }
        return $this->response([], 200);
    }

    public function show(Category $category)
    {
        return $this->response($category);
    }

    public function update(Category $category)
    {
    }

    public function destroy(Category $category)
    {
    }
}
