<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Helpers\ApiResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/products
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 10);
            
            $products = Product::latest()->paginate($perPage);

            return ApiResponseHelper::successWithPagination(
                $products,
                'Products retrieved successfully'
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::serverError(
                'Failed to retrieve products',
                $e->getMessage()
            );
        }
    }

    /**
     * Display the specified resource.
     * GET /api/products/{id}
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return ApiResponseHelper::notFound('Product not found');
            }

            return ApiResponseHelper::success(
                $product,
                'Product retrieved successfully'
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::serverError(
                'Failed to retrieve product',
                $e->getMessage()
            );
        }
    }

    /**
     * Search products by keyword.
     * GET /api/products/search?q=keyword&per_page=10
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'q' => 'required|string|min:1|max:255',
                'per_page' => 'nullable|integer|min:1|max:100',
            ]);

            $keyword = $request->input('q');
            $perPage = $request->input('per_page', 10);

            $products = Product::where('name', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%")
                ->latest()
                ->paginate($perPage);

            return ApiResponseHelper::successWithPagination(
                $products,
                "Search results for '{$keyword}'"
            );
        } catch (ValidationException $e) {
            return ApiResponseHelper::validationError(
                $e->errors(),
                'Invalid search parameters'
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::serverError(
                'Failed to search products',
                $e->getMessage()
            );
        }
    }

    /**
     * Filter products by categories.
     * GET /api/products/filter?category=Clothing,Drinkware&per_page=10
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'category' => 'required|string|max:500',
                'per_page' => 'nullable|integer|min:1|max:100',
            ]);

            $categories = array_map('trim', explode(',', $request->input('category')));
            $perPage = $request->input('per_page', 10);

            $products = Product::whereIn('category', $categories)
                ->latest()
                ->paginate($perPage);

            return ApiResponseHelper::successWithPagination(
                $products,
                'Filtered products retrieved successfully'
            );
        } catch (ValidationException $e) {
            return ApiResponseHelper::validationError(
                $e->errors(),
                'Invalid filter parameters'
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::serverError(
                'Failed to filter products',
                $e->getMessage()
            );
        }
    }

    /**
     * Get all available categories.
     * GET /api/products/categories
     *
     * @return JsonResponse
     */
    public function categories(): JsonResponse
    {
        try {
            $categories = Product::select('category')
                ->distinct()
                ->orderBy('category')
                ->pluck('category');

            return ApiResponseHelper::success(
                $categories,
                'Categories retrieved successfully'
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::serverError(
                'Failed to retrieve categories',
                $e->getMessage()
            );
        }
    }
}