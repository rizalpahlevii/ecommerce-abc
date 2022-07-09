<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $carts = Cart::where('user_id', auth()->id())->get();
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $carts->sum('price'),
                'date' => now(),
                'number' => uniqid(),
            ]);
            $total = 0;
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'price' => Product::find($cart->product_id)->price,
                    'quantity' => $cart->quantity,
                    'subtotal' => Product::find($cart->product_id)->price * $cart->quantity,
                ]);
                $total += (Product::find($cart->product_id)->price * $cart->quantity);
            }
            $order->update(['total' => $total]);
            OrderAddress::create([
                'order_id' => $order->id,
                'province_id' => auth()->user()->address->province_id,
                'province_name' => auth()->user()->address->province_name,
                'city_id' => auth()->user()->address->city_id,
                'city_name' => auth()->user()->address->city_name,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function show(Order $order)
    {
        if ($order->user_id != auth()->id()) abort(403);
    }
}
