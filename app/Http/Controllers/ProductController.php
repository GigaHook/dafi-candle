<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductIndexRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Type;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        private $productService = new ProductService,
        private $orderService = new OrderService,
    ) {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index(ProductIndexRequest $request): \Inertia\Response 
    {
        return Inertia::render('Products/ProductsIndex', [
            'products' => $this->productService->processProducts($request->validated()),
            'types' => Type::all(),
        ]);
    }

    public function create(): \Inertia\Response 
    {
        return Inertia::render('Products/ProductsCreate', [
            'types' => Type::all(),
        ]);
    }

    public function store(ProductStoreRequest $request): RedirectResponse 
    {
        $this->productService->createProduct($request->validated());
        return redirect()->route('products.index');
    }

    public function show(Product $product): \Inertia\Response 
    {
        return Inertia::render('Products/ProductsShow', [
            'product' => $product->load('type'),
            'tags' => $product->tags,
        ]);
    }

    public function edit(Product $product): \Inertia\Response 
    {
        return Inertia::render('Products/ProductsEdit', [
            'product' => $product->load('type'),
            'tags' => $product->tags,
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse 
    {
        $this->productService->updateProduct($request->validated(), $product);
        return redirect()->route('products.index');
    }

    public function destroy(Product $product): RedirectResponse 
    {
        $this->productService->deleteProduct($product);
        return redirect()->route('products.index');
    }
}
