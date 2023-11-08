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
     * Функция создает продукт путем загрузки изображения, создания тегов и отображения всплывающего
     * сообщения.
     * 
     * @param array $data Массив, содержащий данные, необходимые для создания продукта. Эти данные
     * обычно включают в себя такую информацию, как название продукта, описание, цена и изображение.
     */
    public function createProduct(array $data): void 
    {
        $this->fileService->uploadImage($data['image']);
        $this->tagService->createTags(Product::create($data), $data['tags']);
        toast('Товар добавлен');
    }

    /**
     * Функция обновляет изображение, атрибуты и теги продукта на основе предоставленных данных.
     * 
     * @param array $data Массив, содержащий обновленные данные о товаре. Он может включать в себя такие
     * поля, как имя, описание, цена и т. д.
     * @param Product $product Параметр является экземпляром класса Product. Он представляет
     * собой продукт, который необходимо обновить.
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
     * Функция удаляет продукт, удаляет все неиспользуемые теги, связанные с продуктом, и удаляет
     * изображение продукта, если оно не используется каким-либо другим продуктом.
     * 
     * @param Product $product Параметр является экземпляром класса Product.
     * 
     * @return void Если продукт с тем же изображением, что и удаленный продукт, существует, функция
     * вернется без выполнения какого-либо дальнейшего кода.
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
     * Функция обрабатывает продукты на основе заданных данных, включая выбранные типы, текст поиска,
     * критерии сортировки, и возвращает результат с разбивкой на страницы.
     * 
     * @param array $data Параметр представляет собой массив с типами, фильтрами и т.д.
     * 
     * @return LengthAwarePaginator объект LengthAwarePaginator.
     */
    public function processProducts(array $data): LengthAwarePaginator 
    {
        $query = Product::query();

        if (isset($data['showUnavailable']) && $data['showUnavailable'] == 'true') {
            $show = '>=';
        } else $show = '>';

        $query->where('available', $show, 0);

        isset($data['searchText']) && $query->where('name', 'LIKE', '%'.str_replace(' ', '', $data['searchText']).'%');
        isset($data['selectedTypes']) && $query->whereIn('type_id', $data['selectedTypes']);
        isset($data['sortBy'], $data['sortOrder'])
            ? $query->orderBy($data['sortBy'], $data['sortOrder'])
            : $query->orderBy('created_at', 'desc');

        return $query->with('type')->paginate(24);
    }
    
    /**
     * Функция уменьшает доступное количество товаров в зависимости от количества заказанных товаров и
     * сохраняет обновленные значения.
     * 
     * @param array $products Массив объектов класса Product, представляющих продукты заказа
     */
    public function decreaseAvailable(array $products): void 
    {
        foreach ($products as $product) {
            $product->available -= $product->orderItem->quantity;
            
            if ($product->available < 0) {
                $product->available = 0;
            }

            $product->save();
        }
    }
}