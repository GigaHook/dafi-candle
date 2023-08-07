<?php

namespace App\Services;

use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\FileService;
use App\Services\TagService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
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
            $this->fileService->uploadImage($data['image']);

            $product = Product::create($data);

            $this->tagService->createTags($data['tags']);
            $this->tagService->syncTags($product);
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
        else $query->orderBy('created_at', 'desc');

        $products = $query->with('type')->paginate(12);
        
        return $products;
    }

    public function updateProduct(array $data, Product $product): void {
        if (isset($data['image'])) {
            $this->fileService->uploadImage($data['image']);
            $this->fileService->deleteImage($product->image);
        }
        else $data['image'] = $product->image;

        DB::transaction(function() use ($data, $product) {
            $product->update(Arr::except($data, ['tags']));
            $this->tagService->createTags($data['tags']);
            $this->tagService->syncTags($product);
        });
    }

    public function deleteProduct(Product $product): void {
        DB::transaction(function() use($product) {
            $tagIds = $product->tags->pluck('id');
            $product->delete();
            $this->tagService->deleteUnusedTags($tagIds);
        });
    }
}