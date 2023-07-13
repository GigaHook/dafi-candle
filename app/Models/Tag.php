<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
    ];
    public $timestamps = false;

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'product_tags');
    }
}
