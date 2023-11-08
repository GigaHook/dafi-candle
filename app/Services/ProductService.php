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
    public function createProduct(array $data): void 
    {
        $this->fileService->uploadImage($data['image']);
        $this->tagService->createTags(Product::create($data), $data['tags']);
        toast('Товар добавлен');
    }

    /**
     * загрузка нового изрображения и удаление старого,
     * обновление продукта и его тегов, создание новых, удаление неиспольующихся
     */
    public function updateProduct(array $data, Product $product): void 
    {
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
     * Удаление продукта, картинки, отвязка и удаление неиспольующихся тегов
     */
    public function deleteProduct(Product $product): void 
    {
        $tagIds = $product->tags()->pluck('tags.id');
        $product->delete();

        $this->tagService->deleteUnusedTags($tagIds);

        if (Product::where('image', $product->image)->first()) return;

        $this->fileService->deleteImage($product->image);
    }
    
    /**
     * фильтры, поиск, сортировка, пагинация
     */
    public function processProducts(array $data): LengthAwarePaginator 
    {
        $query = Product::query();

        isset($data['selectedTypes']) && $query->whereIn('type_id', $data['selectedTypes']);
        isset($data['searchText']) && $query->where('name', 'LIKE', '%'.str_replace(' ', '', $data['searchText']).'%');
        isset($data['sortBy'], $data['sortOrder'])
            ? $query->orderBy($data['sortBy'], $data['sortOrder'])
            : $query->orderBy('created_at', 'desc');

        return $query->with('type')->paginate(24);
    }
}