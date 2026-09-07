<?php

namespace App\Http\Controllers\Api;

use App\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;
    
    public function getProducts(Request $request): JsonResponse
    {
        $perPage = (int) $request->get('per_page', 15);
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 15;

        $query = Product::query()
            ->with('category')
            ->search($request->get('search'))
            ->category($request->get('category_id'));

         // Filter status aktif/nonaktif jika diminta
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }
 
        // Filter khusus produk yang stoknya sudah menipis
        if ($request->boolean('low_stock')) {
            $query->lowStock();
        }
 
        // Sorting sederhana, default terbaru dulu
        $sortBy = in_array($request->get('sort_by'), ['name', 'price', 'stock', 'created_at'])
            ? $request->get('sort_by')
            : 'created_at';
        $sortDir = $request->get('sort_dir') === 'desc' ? 'desc' : 'asc';
 
        $products = $query->orderBy($sortBy, $sortDir)->paginate($perPage);
 
        return $this->successResponse([
            'products'  => ProductResource::collection($products),
            'meta'      => [
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'per_page'     => $products->perPage(),
                'total'        => $products->total(),
            ],
        ], 'Daftar produk berhasil diambil.');
    }

    public function detailProductById()
    {

    }
}
