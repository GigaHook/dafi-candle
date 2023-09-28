<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\BadgeService;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        private $productService = new ProductService,
        private $badgeService = new BadgeService,
    ) {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index(Request $request): \Inertia\Response {
        return Inertia::render('Products/ProductsIndex', [
            'products' => $this->productService->processProducts($request->all()),
        ]);
    }

    public function create(): \Inertia\Response {
        return Inertia::render('Products/ProductsCreate');
    }

    public function store(ProductStoreRequest $request): RedirectResponse {
        $this->productService->createProduct($request->validated());
        return redirect()->route('products.index');
    }

    public function show(Product $product): \Inertia\Response {
        return Inertia::render('Products/ProductsShow', [
            'product' => $product->load('type'),
            'tags' => $product->tags,
        ]);
    }

    public function edit(Product $product): \Inertia\Response {
        return Inertia::render('Products/ProductsEdit', [
            'product' => $product->load('type'),
            'tags' => $product->tags,
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse {
        $this->productService->updateProduct($request->validated(), $product);
        return redirect()->route('products.index');
    }

    public function destroy(Product $product): RedirectResponse {
        $this->productService->deleteProduct($product);
        return redirect()->route('products.index');
    }
}
