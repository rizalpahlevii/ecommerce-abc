<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'service_name', 'service_description', 'courier_code', 'courier_name', 'cost_value', 'etd'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
