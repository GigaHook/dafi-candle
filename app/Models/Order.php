<?php

namespace App\Models;

use App\Models\Adress;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'adress_id',
        'price',
        'status',
        'viewed_admin',
        'viewed_user',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    
    public function adress(): BelongsTo {
        return $this->belongsTo(Adress::class);
    }

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'orderitems')
                    ->withPivot('quantity')
                    ->as('orderItem');
    }
}
