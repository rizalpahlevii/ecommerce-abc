<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasFactory;

    protected $fillable = ['name', 'price', 'weight', 'description', 'category'];
}
