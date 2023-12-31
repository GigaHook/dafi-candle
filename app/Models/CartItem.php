<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cartitems';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'viewed',
    ];
}
