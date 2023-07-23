<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Tag;

class TagService 
{
    public function createTag(array $data, Product $product): void {
        $product->tags()->attach(Tag::firstOrCreate([
            'name' => $data['name'],
            'value' => $data['value'],
        ])->id);
    }
}