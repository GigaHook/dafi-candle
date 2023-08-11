<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Tag;

class TagService 
{
    public function createTags(Product $product, array $tagData): void {
        $newTagIds = [];

        foreach ($tagData as $tag) {
            $newTagIds[] = Tag::firstOrCreate([
                'name' => $tag['name'],
                'value' => $tag['value'],  
            ])->id;
        }

        $product->tags()->sync($newTagIds);
    }

    public function updateTags(Product $product, array $tagData): void {
        $newTagIds = [];

        foreach ($tagData as $tag) {
            $newTagIds[] = Tag::firstOrCreate([
                'name' => $tag['name'],
                'value' => $tag['value'],  
            ])->id;
        }

        $currentIds = $product->tags()->pluck('tags.id');
        $product->tags()->sync($newTagIds);
        $updatedIds = $product->tags()->pluck('tags.id');
        $detachedIds = $currentIds->diff($updatedIds);
        
        $this->deleteUnusedTags($detachedIds);
    }

    public function deleteUnusedTags($detachedIds): void {
        Tag::whereKey($detachedIds)->doesntHave('products')->delete();
    }
}