<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
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

    public function index(): InertiaResponse {
        return Inertia::render('Products/ProductsIndex', [
            'products' => Product::paginate(12),
        ]);
    }

    public function create(): InertiaResponse {
        return Inertia::render('Products/ProductsCreate');
    }

    public function store(ProductStoreRequest $request): RedirectResponse {
        $this->productService->createProduct($request->validated());
        return back();
    }

    public function show(string $id) {
        return Inertia::render('Products/ProductsShow', ['product' => Product::find($id)]);
    }

    public function edit(string $id) {
        return Inertia::render('Products/ProductsEdit', ['product' => Product::find($id)]);
    }

    public function update(Request $request, string $id) {
        //
    }

    public function destroy(string $id): RedirectResponse {
        Product::destroy($id);
        return back();
    }
}
