<?php

namespace App\Models;

use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'type_id',
        'available'
    ];

    public function type(): BelongsTo {
        return $this->belongsTo(Type::class);
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }
}
