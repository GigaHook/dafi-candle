<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adress extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'orderadress';
    protected $fillable = [
        'user_id',
        'type',
        'city',
        'street',
        'house_number',
        'flat_number',
        'postal_code',
        'name',
        'middlename',
        'lastname',
        'tel',
    ];
    
    public function orders(): HasMany {
        return $this->hasMany(Order::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
