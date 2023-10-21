<?php

namespace App\Services;

use App\Models\Product;
use App\Services\FileService;
use App\Services\TagService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class ProductService 
{
    public function __construct(
        protected $tagService = new TagService,
        protected $fileService = new FileService,
    ) {}

    /**
     * качает изображение, создаёт продукт и теги если они есть и связывает их
     * @param array $data
     * @return void
     */
    public function createProduct(array $data): void {
        $this->fileService->uploadImage($data['image']);
        $this->tagService->createTags(
            Product::create($data),
            $data['tags']
        );
        toast('Товар добавлен');
    }

    /**
     * загрузка нового изрображения и ядаление старого,
     * обновление продукта и его тегов, создание новых, удаление неиспольующихся
     * @param array $data
     * @param \App\Models\Product $product
     * @return void
     */
    public function updateProduct(array $data, Product $product): void {
        if (isset($data['image'])) {
            $this->fileService->uploadImage($data['image']);
            $this->fileService->deleteImage($product->image);
        } else {
            $data['image'] = $product->image;
        }

        $product->update(Arr::except($data, ['tags']));
        $product->refresh();
        $this->tagService->updateTags($product, $data['tags']);
    }

    /**
     * Удаление продукта, картинки, отвязка тегов и удаление неиспольующихся
     * @param \App\Models\Product $product
     * @return void
     */
    public function deleteProduct(Product $product): void {
        $tagIds = $product->tags()->pluck('tags.id');
        $product->delete();
        $this->tagService->deleteUnusedTags($tagIds);
        $this->fileService->deleteImage($product->image);        
    }
    
    /**
     * фильтры, сортировка, пагинация
     * @param array $data
     * @return array
     */
    public function processProducts(array $data): LengthAwarePaginator {
        $query = Product::query();

        if (isset($data['selectedTypes'])) {
            $query->whereIn('type_id', $data['selectedTypes']);
        }

        if (isset($data['sortBy']) && isset($data['sortOrder'])) {
            $query->orderBy($data['sortBy'], $data['sortOrder']);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->with('type')->paginate(12);
        
        return $products;
    }
}