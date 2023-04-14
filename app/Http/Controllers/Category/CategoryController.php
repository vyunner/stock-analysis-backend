<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){

    }
    public function store(){
        Category::create([
            'name' => 'LAX'
        ]);
    }
    public function show(Category $category){
        return $this->response($category);
    }
    public function update(Category $category){

    }
    public function destroy(Category $category){

    }
}
