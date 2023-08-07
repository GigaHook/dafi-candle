<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ProductController extends Controller
{
    protected $productService;
    
    public function __construct() {
        $this->productService = new ProductService();
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index(Request $request): InertiaResponse {
        $products = $this->productService->prepareProducts($request->all());
        return Inertia::render('Products/ProductsIndex', [
            'products' => $products,
        ]);
    }

    public function create(): InertiaResponse {
        return Inertia::render('Products/ProductsCreate');
    }

    public function store(ProductStoreRequest $request): RedirectResponse {
        $this->productService->createProduct($request->validated());
        return redirect()->route('products.index');
    }

    public function show(Product $product) {
        return Inertia::render('Products/ProductsShow', [
            'product' => $product->load('type'),
            'tags' => $product->tags,
        ]);
    }

    public function edit(Product $product) {
        return Inertia::render('Products/ProductsEdit', [
            'product' => $product->load('type'),
            'tags' => $product->tags,
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product) {
        $this->productService->updateProduct($request->validated(), $product);
        return redirect()->route('products.index');
    }

    public function destroy(Product $product): RedirectResponse {
        //$product->delete();
        return redirect()->route('products.index');
    }
}
