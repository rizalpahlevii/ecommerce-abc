<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'province_name', 'province_id', 'city_name', 'city_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
