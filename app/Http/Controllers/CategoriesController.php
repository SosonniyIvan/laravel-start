<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Facades\Cart;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(12);

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $childs = $category->children();
        $categories = Category::paginate(12);
        $product = (new \App\Models\Category)->products();
        return view('categories.show', compact('category', 'childs', 'categories', 'product'));
    }
}
