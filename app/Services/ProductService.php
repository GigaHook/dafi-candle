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
        private $tagService = new TagService,
        private $fileService = new FileService,
    ) {}

    /**
     * качает изображение, создаёт продукт и теги если они есть и связывает их
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
     */
    public function deleteProduct(Product $product): void {
        $tagIds = $product->tags()->pluck('tags.id');
        $product->delete();
        $this->tagService->deleteUnusedTags($tagIds);
        $this->fileService->deleteImage($product->image);        
    }
    
    /**
     * фильтры, сортировка, пагинация
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