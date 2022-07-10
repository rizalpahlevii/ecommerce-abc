<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(9);
        return view('pages.products.index', compact('products'));
    }

    public function show($productId)
    {
        $product = Product::find($productId);
        return view('pages.products.show', compact('product'));
    }
}
