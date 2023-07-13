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
        return Inertia::render('ProductIndex');
    }

    public function create(): InertiaResponse {
        return Inertia::render('ProductCreate');
    }

    public function store(ProductStoreRequest $request): RedirectResponse {
        $data = $request->validated();
        $this->productService->createProduct($data);
        return back();
    }

    public function show(string $id) {
        return Inertia::render('ProductShow', ['product' => Product::find($id)]);
    }

    public function edit(string $id) {
        return Inertia::render('ProductEdit', ['product' => Product::find($id)]);
    }

    public function update(Request $request, string $id) {
        //
    }

    public function destroy(string $id): RedirectResponse {
        Product::destroy($id);
        return back();
    }
}
