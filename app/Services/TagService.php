<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class TagService 
{
    private static $newIds;

    public function createTags(array $tagData): void {
        $tags = [];

        foreach ($tagData as $tag) {
            $tags[] = Tag::firstOrCreate([
                'name' => $tag['name'],
                'value' => $tag['value'],  
            ]);
        }

        self::$newIds = Arr::pluck($tags, 'id');
    }

    public function syncTags(Product $product): void {
        if ($product->tags->count() == 0) {
            $product->tags()->sync(self::$newIds); 
            self::$newIds = [];
            return;
        }

        $currentIds = $product->tags->pluck('id');
        $product->tags()->sync(self::$newIds);  
        $updatedIds = $product->tags->pluck('id');
        $detachedIds = $currentIds->diff($updatedIds);

        $this->deleteUnusedTags($detachedIds);

        self::$newIds = [];
    }

    public function deleteUnusedTags($detachedIds): void {
        Tag::whereKey($detachedIds)->doesntHave('products')->delete();
    }
}