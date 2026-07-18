<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::where('is_active', 1)->count();
        $totalCategories = Category::where('is_active', 1)->count();
        $totalBanners = Banner::where('is_active', 1)->count();
        $featuredProducts = Product::where('is_featured', 1)->where('is_active', 1)->count();

        $recentProducts = Product::with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('dashboard.index', compact(
            'totalProducts', 
            'totalCategories', 
            'totalBanners', 
            'featuredProducts', 
            'recentProducts'
        ));
    }
}