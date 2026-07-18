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

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            $destination = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/categories';

            if (!file_exists($destination)) {
                mkdir($destination, 0775, true);
            }

            $file->move($destination, $filename);

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

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            $destination = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/categories';

            if (!file_exists($destination)) {
                mkdir($destination, 0775, true);
            }

            if ($category->image && file_exists($destination . '/' . basename($category->image))) {
                unlink($destination . '/' . basename($category->image));
            }

            $file->move($destination, $filename);

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

        $destination = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/categories';

        if ($category->image && file_exists($destination . '/' . basename($category->image))) {
            unlink($destination . '/' . basename($category->image));
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