<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Tag;
use App\Services\FileService;
use App\Services\TagService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductService 
{
    protected $tagService;
    protected $fileService;

    public function __construct() {
        $this->tagService = new TagService();
        $this->fileService = new FileService();
    }

    public function createProduct(Collection $data): void {
        DB::transaction(function() use ($data) {
            $data = $data->merge(['image' => $this->fileService->uploadImage($data->get('image')[0])]);
            $product = Product::create($data->except(['tags'])->all());
            foreach ($data['tags'] as $tagData) 
            $this->tagService->createTag($tagData, $product);
        });
    }
}