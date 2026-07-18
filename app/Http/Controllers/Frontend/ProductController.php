<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, $categorySlug = null)
    {
        $search = $request->query('q');
        $query = Product::with(['category', 'images'])->where('is_active', 1);

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $products = $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->get();
        $allCategories = Category::where('is_active', 1)->orderBy('sort_order', 'asc')->get();
        $activeCategory = $categorySlug ? $allCategories->where('slug', $categorySlug)->first() : null;

        return view('frontend.pages.catalog', compact('products', 'allCategories', 'activeCategory', 'categorySlug', 'search'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->firstOrFail(); 

        $images = $product->images()
            ->orderBy('is_primary', 'desc')
            ->orderBy('sort_order', 'asc')
            ->get();

        $relatedProducts = Product::with(['images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', 1)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $mainImg = $images->first()->image ?? null;

        return view('frontend.pages.product', compact('product', 'images', 'relatedProducts', 'mainImg'));
    }
}