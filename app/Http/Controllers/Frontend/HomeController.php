<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        $categories = Category::withCount(['products as product_count' => function ($q) {
                $q->where('is_active', 1);
            }])
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        $featured = Product::with(['category', 'images'])
            ->where('is_featured', 1)
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        return view('frontend.index', [
            'banners' => $banners,
            'categories' => $categories,
            'featured' => $featured,
            'whatsapp' => Setting::getValue('whatsapp_number'),
            'heroTitle' => Setting::getValue('hero_title'),
            'heroSubtitle' => Setting::getValue('hero_subtitle'),
        ]);
    }

    public function about()
    {
        return view('frontend.pages.about');
    }

    public function contact()
    {
        $whatsapp = Setting::getValue('whatsapp_number'); 
        $address = Setting::getValue('address');
        $email = Setting::getValue('email');
        $instagram = Setting::getValue('instagram');
        $waGreeting = Setting::getValue('whatsapp_greeting');

        return view('frontend.pages.contact', compact(
            'whatsapp', 
            'address', 
            'email', 
            'instagram', 
            'waGreeting'
        ));
    }
}