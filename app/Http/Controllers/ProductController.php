<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ProductController extends Controller
{
    
    public function __construct() {
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): InertiaResponse
    {
        return Inertia::render('ProductIndex');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): InertiaResponse
    {
        return Inertia::render('ProductCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('ProductShow', ['product' => Product::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('ProductEdit', ['product' => Product::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Product::destroy($id);
        return back();
    }
}
