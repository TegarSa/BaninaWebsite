<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    const LIMIT_HERO = 5;
    const LIMIT_POPUP = 1;

    public function index()
    {
        $banners = Banner::orderBy('type', 'asc')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $activeHeroCount = Banner::where('type', 'hero')->where('is_active', 1)->count();
        $activePopupCount = Banner::where('type', 'popup')->where('is_active', 1)->count();

        return view('dashboard.banner.index', compact('banners', 'activeHeroCount', 'activePopupCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'       => 'required|in:hero,popup',
            'image'      => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'link'       => 'nullable|url',
        ], [
            'image.required' => 'Foto banner wajib diupload.',
            'image.image'    => 'File harus berupa gambar.',
            'image.max'      => 'Ukuran foto maksimal 2MB.',
            'link.url'       => 'Format URL tidak valid, harus diawali https://',
        ]);

        if ($request->type === 'hero') {
            $currentActive = Banner::where('type', 'hero')->where('is_active', 1)->count();
            if ($currentActive >= self::LIMIT_HERO) {
                return back()->withInput()->with('error', 'Gagal menyimpan! Kuota maksimal Banner Hero yang aktif sudah penuh (' . self::LIMIT_HERO . ' banner). Nonaktifkan banner lain terlebih dahulu.');
            }
        } elseif ($request->type === 'popup') {
            $currentActive = Banner::where('type', 'popup')->where('is_active', 1)->count();
            if ($currentActive >= self::LIMIT_POPUP) {
                return back()->withInput()->with('error', 'Gagal menyimpan! Kuota maksimal Pop-up Promo yang aktif sudah penuh (' . self::LIMIT_POPUP . ' banner). Nonaktifkan pop-up yang sedang aktif terlebih dahulu.');
            }
        }

        $imgPath = null;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            $destination = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/banners';

            if (!file_exists($destination)) {
                mkdir($destination, 0775, true);
            }

            $file->move($destination, $filename);

            $imgPath = 'banners/' . $filename;
        }

        Banner::create([
            'type' => $request->type,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'link' => $request->link,
            'sort_order' => $request->sort_order ?? 0,
            'image' => $imgPath,
            'is_active' => 1
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('dashboard.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'type'       => 'required|in:hero,popup',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'link'       => 'nullable|url',
        ], [
            'image.image' => 'File harus berupa gambar.',
            'image.max'   => 'Ukuran foto maksimal 2MB.',
            'link.url'    => 'Format URL tidak valid, harus diawali https://',
        ]);

        if ($banner->type !== $request->type && $banner->is_active == 1) {
            if ($request->type === 'hero') {
                $currentActive = Banner::where('type', 'hero')->where('is_active', 1)->count();
                if ($currentActive >= self::LIMIT_HERO) {
                    return back()->with('error', 'Gagal memperbarui! Tipe Hero Slider pilihanmu sudah penuh.');
                }
            } elseif ($request->type === 'popup') {
                $currentActive = Banner::where('type', 'popup')->where('is_active', 1)->count();
                if ($currentActive >= self::LIMIT_POPUP) {
                    return back()->with('error', 'Gagal memperbarui! Tipe Pop-up Promo pilihanmu sudah penuh.');
                }
            }
        }

        $imgPath = $banner->image;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            $destination = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/banners';

            if (!file_exists($destination)) {
                mkdir($destination, 0775, true);
            }

            if ($banner->image && file_exists($destination . '/' . basename($banner->image))) {
                unlink($destination . '/' . basename($banner->image));
            }

            $file->move($destination, $filename);

            $imgPath = 'banners/' . $filename;
        }

        $banner->update([
            'type' => $request->type,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'link' => $request->link,
            'sort_order' => $request->sort_order ?? 0,
            'image' => $imgPath
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        $destination = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/banners';

        if ($banner->image && file_exists($destination . '/' . basename($banner->image))) {
            unlink($destination . '/' . basename($banner->image));
        }

        $banner->delete();
        return redirect()->route('banners.index')->with('success', 'Banner berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $banner = Banner::findOrFail($id);
        
        if (!$banner->is_active) {
            if ($banner->type === 'hero') {
                $currentActive = Banner::where('type', 'hero')->where('is_active', 1)->count();
                if ($currentActive >= self::LIMIT_HERO) {
                    return back()->with('error', 'Tidak bisa mengaktifkan! Kuota Banner Hero aktif sudah maksimal (Maks ' . self::LIMIT_HERO . ').');
                }
            } elseif ($banner->type === 'popup') {
                $currentActive = Banner::where('type', 'popup')->where('is_active', 1)->count();
                if ($currentActive >= self::LIMIT_POPUP) {
                    return back()->with('error', 'Tidak bisa mengaktifkan! Kuota Pop-up Promo aktif sudah maksimal (Maks ' . self::LIMIT_POPUP . ').');
                }
            }
        }

        $banner->is_active = !$banner->is_active;
        $banner->save();

        return back()->with('success', 'Status aktif banner berhasil diubah.');
    }
}