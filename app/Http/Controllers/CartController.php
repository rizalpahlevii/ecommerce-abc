<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())->get();
    }


    public function store(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())->where('product_id', $request->product_id)->first();
        if ($cart) {
            $cart->quantity += $request->quantity;
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }
    }

    public function delete(Cart $cart)
    {
        if ($cart->user_id != auth()->id()) abort(403);
        $cart->delete();
    }
    public function increment(Cart $cart)
    {
        if ($cart->user_id != auth()->id()) abort(403);
        $cart->increment('quantity');
    }
    public function decrement(Cart $cart)
    {
        if ($cart->user_id != auth()->id()) abort(403);
        $cart->decrement('quantity');
    }
}
