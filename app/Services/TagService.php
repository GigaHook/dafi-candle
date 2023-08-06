<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Tag;

class TagService 
{
    public function createTags(array $tags, Product $product): void {
        $tagIds = [];

        foreach ($tags as $tag) {
            $tagIds[] = Tag::firstOrCreate([
                'name' => $tag['name'],
                'value' => $tag['value'],  
            ])->id;
        }

        $product->tags()->sync($tagIds);
        
        //$product->tags()->attach(Tag::firstOrCreate([
        //    'name' => $tag['name'],
        //    'value' => $tag['value'],
        //])->id);
    }

    public function updateTags(array $tags, Product $product): void {
        $tagIds = Tag::whereIn('name', array_column($tags, 'name'))
                    ->whereIn('value', array_column($tags, 'value'))
                    ->groupBy('name', 'value')
                    ->havingRaw('COUNT(*) = ?', [count($tags)]) //fckng magic
                    ->pluck('id');
        
        $product->tags()->sync($tagIds);

        //лажа
        //надо firstOrCreate'нуть каждый из переданных тегов,
        //потом сунуть всё в массив или коллекцию
        //потом из этого всего взять только id
        //и засинхронить с этим массивом id
    }

    public function deleteTag(array $tag, Product $product): void {

    }
}