<?php

namespace App\Http\Controllers;

use App\Helpers\RajaOngkir;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function getProvinces()
    {
        return json_encode(RajaOngkir::getProvinces());
    }

    public function getCities($provinceId)
    {
        return json_encode(RajaOngkir::getCities($provinceId));
    }

    public function getCosts(Request $request)
    {
        $carts = Cart::where('user_id', auth()->id())->get();
        $weight = 0;
        foreach ($carts as $cart) {
            $weight += (Product::find($cart->product_id)->weight * $cart->quantity);
        }
        return RajaOngkir::getCost(344, $request->city_id, $weight, $request->courier_code);
    }
}
