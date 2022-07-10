<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Kodepandai\LaravelRajaOngkir\RajaOngkir as LaravelRajaOngkirRajaOngkir;

class RajaOngkir
{
    public static function getProvinces()
    {
        return json_decode(Http::withHeaders([
            'key' => config('rajaongkir.API_KEY'),
            'content-type' => 'application/x-www-form-urlencoded',
        ])->get('https://api.rajaongkir.com/starter/province'))->rajaongkir;
    }

    public static function getCities($provinceId)
    {
        return json_decode(Http::withHeaders([
            'key' => config('rajaongkir.API_KEY'),
            'content-type' => 'application/x-www-form-urlencoded',
        ])->get('https://api.rajaongkir.com/starter/city', ['province' => $provinceId]))->rajaongkir;
    }

    public static function getCost($origin, $destination, $weight, $courier = "jne")
    {
        return json_decode(Http::withHeaders([
            'key' => config('rajaongkir.API_KEY'),
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
        ]))->rajaongkir;
    }
}
