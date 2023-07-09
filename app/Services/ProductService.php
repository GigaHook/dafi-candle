<?php

namespace App\Services;

use App\Models\Product;



class ProductService 
{
    public function createProduct(mixed $data): Product {
        Product::Create
    }
}