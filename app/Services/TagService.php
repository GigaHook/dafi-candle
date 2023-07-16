<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Collection;

class TagService 
{
    public function createTag(array $data, Product $product): void {
        $product->tags()->attach(Tag::create([
            'name' => $data['name'],
            'value' => $data['value'],
        ])->id);
    }
}