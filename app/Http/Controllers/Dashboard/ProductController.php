<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');
        $catFilter = $request->get('cat');

        $query = Product::with(['category', 'images']);

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if ($catFilter) {
            $query->where('category_id', $catFilter);
        }

        $products = $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->get();
        $allCats = Category::orderBy('sort_order', 'asc')->get();

        return view('dashboard.product.index', compact('products', 'allCats', 'search', 'catFilter'));
    }

    public function create()
    {
        $allCats = Category::where('is_active', 1)->orderBy('sort_order', 'asc')->get();
        return view('dashboard.product.create', compact('allCats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'price_min' => 'required|numeric|min:1',
            'price_max' => 'nullable|numeric|gte:price_min',
            'shopee_url' => 'nullable|url',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'price_min.required' => 'Harga minimal wajib diisi.',
            'price_max.gte' => 'Harga maksimal tidak boleh lebih kecil dari harga minimal.',
        ]);

        $slug = Str::slug($request->name);
        if (Product::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price_min' => $request->price_min,
            'price_max' => $request->price_max,
            'shopee_url' => $request->shopee_url,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'sort_order' => 0
        ]);

        // Proses Multi Upload Gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                // Simpan ke folder public/assets/images/products
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/images/products'), $filename);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'products/' . $filename,
                    'is_primary' => $key === 0 ? 1 : 0,
                    'sort_order' => $key
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $allCats = Category::where('is_active', 1)->orderBy('sort_order', 'asc')->get();
        return view('dashboard.product.edit', compact('product', 'allCats'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'price_min' => 'required|numeric|min:1',
            'price_max' => 'nullable|numeric|gte:price_min',
            'shopee_url' => 'nullable|url',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $slug = Str::slug($request->name);
        if (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug .= '-' . time();
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price_min' => $request->price_min,
            'price_max' => $request->price_max,
            'shopee_url' => $request->shopee_url,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        if ($request->hasFile('images')) {
            $hasPrimary = $product->images()->where('is_primary', 1)->exists();
            foreach ($request->file('images') as $key => $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/images/products'), $filename);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'products/' . $filename,
                    'is_primary' => (!$hasPrimary && $key === 0) ? 1 : 0,
                    'sort_order' => $product->images()->count() + $key
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);

        foreach ($product->images as $img) {
            $filePath = public_path('assets/images/' . $img->image);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk beserta gambar berhasil dihapus.');
    }

    // Fitur Cepat ubah status unggulan via tombol bintang
    public function toggleFeature($id)
    {
        $product = Product::findOrFail($id);
        $product->is_featured = !$product->is_featured;
        $product->save();

        return back()->with('success', 'Status unggulan produk berhasil diubah.');
    }

    // Fitur Cepat aktif / nonaktif via tombol switch toggle
    public function toggleActive($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return back()->with('success', 'Status visibilitas produk berhasil diubah.');
    }

    // Menjadikan salah satu gambar sebagai gambar cover/utama
    public function setPrimaryImage($id, $imgId)
    {
        ProductImage::where('product_id', $id)->update(['is_primary' => 0]);
        ProductImage::where('id', $imgId)->update(['is_primary' => 1]);

        return back()->with('success', 'Gambar utama berhasil diubah.');
    }

    // Menghapus satuan gambar pelengkap di dalam form edit
    public function destroyImage($id, $imgId)
    {
        $img = ProductImage::where('id', $imgId)->where('product_id', $id)->firstOrFail();
        $filePath = public_path('assets/images/' . $img->image);
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        $img->delete();

        return back()->with('success', 'Gambar pendukung berhasil dihapus.');
    }
}