<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'count'
    ];

    public static $recentCreatedThreshold = 10;

    public function wasRecentlyCreated(): bool {
        return $this->wasRecentlyCreated;
    }
}
