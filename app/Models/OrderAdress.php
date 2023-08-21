<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderAdress extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'orderadress';
    protected $fillable = [
        'order_id',
        'type',
        'city',
        'street',
        'house_number',
        'flat_number',
        'postal_code',
        'name',
        'middlename',
        'lastname',
    ];
    
    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }
}
