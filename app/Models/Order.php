<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'total', 'number', 'payment_method', 'grandtotal', 'shipping_cost'];

    public function delivery()
    {
        return $this->hasOne(OrderDelivery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function address()
    {
        return $this->hasOne(OrderAddress::class);
    }
}
