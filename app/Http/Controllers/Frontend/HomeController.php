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
        $banners = Banner::where('type', 'hero')
                        ->where('is_active', 1)
                        ->orderBy('sort_order', 'asc')
                        ->take(5) 
                        ->get();

        $popupBanner = Banner::where('type', 'popup')
                            ->where('is_active', 1)
                            ->orderBy('sort_order', 'asc')
                            ->first();

        $featured = Product::with(['images', 'category'])
                        ->where('is_featured', 1)
                        ->where('is_active', 1)
                        ->take(8)
                        ->get();

        $categories = Category::where('is_active', 1)
                            ->orderBy('sort_order', 'asc')
                            ->get();

        $heroTitle = "Koleksi Eksklusif";
        $heroSubtitle = "Temukan kenyamanan beribadah dan keanggunan berbusana dengan produk premium kami.";

        $ctaImage = Setting::getValue('cta_image');

        return view('frontend.index', compact(
            'banners', 
            'popupBanner', 
            'featured', 
            'categories', 
            'heroTitle', 
            'heroSubtitle',
            'ctaImage'
        ));
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