<?php

namespace App\Services;

use App\Models\Product;
use App\Services\FileService;
use App\Services\TagService;
use Illuminate\Support\Facades\DB;

class ProductService 
{
    protected $tagService;
    protected $fileService;

    public function __construct() {
        $this->tagService = new TagService();
        $this->fileService = new FileService();
    }

    public function createProduct(array $data): void {
        DB::transaction(function() use ($data) {
            $data['image'] = $this->fileService->uploadImage($data['image']);
            $product = Product::create($data);
            if (empty($data['tags'])) return;
            foreach ($data['tags'] as $tag) {
                $this->tagService->createTag($tag, $product);
            }
        });
    }

    public function prepareProps(array $data): array {
        return [
            'products' => $this->sortProducts($data),
            'prevSortValue' => $data['sortValue'] ?? null,
            'prevExpanded' => (bool) ($data['expanded'] ?? false),
            'prevSelectedTypes' => $data['selectedTypes'] ?? null
        ];
    }

    private function sortProducts(array $data) {
        $query = Product::query()->with('type');
        if (isset($data['sortBy'])) {
            $query->orderBy($data['sortBy'], $data['sortOrder']);
        }
        return $query->paginate(12);
    }
}