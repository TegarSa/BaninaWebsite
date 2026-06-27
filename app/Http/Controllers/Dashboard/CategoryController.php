<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        // Mengambil kategori sekalian menghitung jumlah produk terkait (product_count)
        $categories = Category::withCount('products')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|max:255|unique:categories,name',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah ada, gunakan nama lain.',
            'image.image'   => 'File harus berupa gambar.',
            'image.max'     => 'Ukuran foto maksimal 2MB.',
        ]);

        $slug = Str::slug($request->name);
        if (Category::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $imgPath = null;
        if ($request->hasFile('image')) {
            \Illuminate\Support\Facades\File::ensureDirectoryExists(public_path('assets/images/categories'));
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/categories'), $filename);
            $imgPath = 'categories/' . $filename;
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'image' => $imgPath,
            'is_active' => 1
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'       => 'required|max:255|unique:categories,name,' . $id,
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah ada, gunakan nama lain.',
            'image.image'   => 'File harus berupa gambar.',
            'image.max'     => 'Ukuran foto maksimal 2MB.',
        ]);

        $slug = Str::slug($request->name);
        if (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug .= '-' . time();
        }

        $imgPath = $category->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($category->image && file_exists(public_path('assets/images/' . $category->image))) {
                @unlink(public_path('assets/images/' . $category->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/categories'), $filename);
            $imgPath = 'categories/' . $filename;
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'image' => $imgPath
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image && file_exists(public_path('assets/images/' . $category->image))) {
            @unlink(public_path('assets/images/' . $category->image));
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $category = Category::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        return back()->with('success', 'Status aktif kategori berhasil diubah.');
    }
}