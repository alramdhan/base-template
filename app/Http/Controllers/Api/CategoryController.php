<?php

namespace App\Http\Controllers\Api;

use App\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    use ApiResponse;
    
    public function getCategories()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();
 
        return $this->successResponse($categories, 'berhasil ambil data kategori.');
    }
}
