<?php

namespace App\Services;

use App\Models\Product;
use App\Services\FileService;
use App\Services\TagService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductService 
{
    protected $tagService;
    protected $fileService;
 
    public function __construct() {
        $this->tagService = new TagService();
        $this->fileService = new FileService();
    }

    /**
     * качает изображение, создаёт продукт и теги если они есть и связывает их
     * @param array $data
     * @return void
     */
    public function createProduct(array $data): void {
        DB::transaction(function() use ($data) {
            $data['image'] = $this->fileService->uploadImage($data['image']);

            $product = Product::create($data);
            
            foreach ($data['tags'] as $tag) {
                $this->tagService->createTag($tag, $product);
            }
        });
    }

    /**
     * фильтры, сортировка, пагинация
     * @param array $data
     * @return array
     */
    public function prepareProducts(array $data): LengthAwarePaginator {
        $query = Product::query();

        if (isset($data['selectedTypes'])) {
            $query->whereIn('type_id', $data['selectedTypes']);
        }

        if (isset($data['sortBy']) && isset($data['sortOrder'])) {
            $query->orderBy($data['sortBy'], $data['sortOrder']);
        }

        $products = $query->with('type')->paginate(12);
        
        return $products;
    }
}