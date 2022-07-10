<?php

namespace App\Http\Controllers;

use App\Helpers\RajaOngkir;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())->get();
        return view('pages.carts.index', compact('carts'));
    }

    public function checkout()
    {
        $provinces = RajaOngkir::getProvinces();
        $carts = Cart::where('user_id', auth()->id())->get();
        return view('pages.carts.checkout', compact('carts', 'provinces'));
    }


    public function store(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())->where('product_id', $request->product_id)->first();
        if ($cart) {
            $cart->quantity += ($request->quantity ?? 1);
            $cart->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity ?? 1
            ]);
        }
        return redirect()->back();
    }

    public function delete($cartId)
    {
        $cart = Cart::find($cartId);
        if ($cart->user_id != auth()->id()) abort(403);
        $cart->delete();
        return redirect()->back();
    }
    public function increment($cartId)
    {
        $cart = Cart::find($cartId);
        if ($cart->user_id != auth()->id()) abort(403);
        $cart->increment('quantity');
        return redirect()->back();
    }
    public function decrement($cartId)
    {
        $cart = Cart::find($cartId);
        if ($cart->user_id != auth()->id()) abort(403);
        $cart->decrement('quantity');
        if ($cart->quantity == 0) $cart->delete();
        return redirect()->back();
    }
}
