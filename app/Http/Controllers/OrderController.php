<?php

namespace App\Http\Controllers;

use App\Helpers\RajaOngkir;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderDelivery;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('pages.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'courier_code' => ['required', Rule::in(config('rajaongkir.AVAILABLE_COURIERS'))],
            'service_code' => ['required'],
            'cost_value' => ['required'],
            'cost_etd' => ['required']
        ]);
        DB::beginTransaction();
        try {
            $carts = Cart::where('user_id', auth()->id())->get();
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $carts->sum('price'),
                'date' => now(),
                'number' => uniqid(),
                'total' => 0,
                'shipping_cost' => 0,
                'grandtotal' => 0,
            ]);
            $total = 0;
            $weight = 0;
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'price' => Product::find($cart->product_id)->price,
                    'quantity' => $cart->quantity,
                    'subtotal' => Product::find($cart->product_id)->price * $cart->quantity,
                ]);
                $weight += (Product::find($cart->product_id)->weight * $cart->quantity);
                $total += (Product::find($cart->product_id)->price * $cart->quantity);
            }

            $address = OrderAddress::create([
                'order_id' => $order->id,
                'province_id' => $request->province_id,
                'province_name' => $request->province_name,
                'city_id' => $request->city_id,
                'city_name' => $request->city_name,
            ]);
            $costs = RajaOngkir::getCost(344, $address->city_id, $weight, $request->courier_code);
            foreach ($costs->results  as $result) {
                if ($result->code == $request->courier_code) {
                    foreach ($result->costs as $cost) {
                        if ($cost->service == $request->service_code) {
                            foreach ($cost->cost as $_cost) {
                                if ($_cost->value == intval($request->cost_value) && $_cost->etd == $request->cost_etd) {
                                    $delivery = OrderDelivery::create([
                                        'order_id' => $order->id,
                                        'courier_code' => $result->code,
                                        'courier_name' => $result->name,
                                        'service_name' => $cost->service,
                                        'service_description' => $cost->description,
                                        'cost_value' => $_cost->value,
                                        'etd' => $_cost->etd,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            $order->update([
                'total' => $total,
                'shipping_cost' => $delivery->cost_value,
                'grandtotal' => $total + $delivery->cost_value,
            ]);
            Cart::where('user_id', auth()->id())->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        return redirect()->route('orders.index');
    }

    public function show($orderId)
    {
        $order = Order::find($orderId);
        $order = $order->load(['address', 'delivery', 'items.product']);
        return view('pages.orders.show', compact('order'));
    }
}
