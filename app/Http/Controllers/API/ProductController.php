<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get all products with pagination
     * GET /api/products
     * Query params: per_page (default: 10)
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $products = Product::paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'last_page' => $products->lastPage(),
            ],
        ]);
    }

    /**
     * Get product detail
     * GET /api/products/{id}
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product retrieved successfully',
            'data' => $product,
        ]);
    }

    /**
     * Search products by name
     * GET /api/products/search?q=keyword
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:1',
        ]);

        $keyword = $request->input('q');
        $perPage = $request->input('per_page', 10);

        $products = Product::where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Search results retrieved successfully',
            'data' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'last_page' => $products->lastPage(),
            ],
        ]);
    }

    /**
     * Filter products by category
     * GET /api/products/filter?category=Clothing
     * Multiple categories: ?category=Clothing,Drinkware
     */
    public function filter(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
        ]);

        $categories = explode(',', $request->input('category'));
        $perPage = $request->input('per_page', 10);

        $products = Product::whereIn('category', $categories)
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Filtered products retrieved successfully',
            'data' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'last_page' => $products->lastPage(),
            ],
        ]);
    }

    /**
     * Get available categories
     * GET /api/products/categories
     */
    public function categories()
    {
        $categories = Product::select('category')
            ->distinct()
            ->pluck('category');

        return response()->json([
            'success' => true,
            'message' => 'Categories retrieved successfully',
            'data' => $categories,
        ]);
    }
}