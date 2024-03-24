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
        $category->load('children', 'products');
        $products = $category->products()->paginate(3);

        return view('categories.show', compact('category', 'products'));
    }
}
