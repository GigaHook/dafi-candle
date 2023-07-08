<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    
    protected static $typeService = new TypeService();

    public function __construct() {
        //$this->middleware('admin')->only('create', 'delete'); TODO: middleware
    }

    public function index(): JsonResponse {
        
    }
}
