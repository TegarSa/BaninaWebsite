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
            'type' => 'required|in:hero,popup',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer',
            'link' => 'nullable|url'
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
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/banners'), $filename);
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
            'type' => 'required|in:hero,popup',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer',
            'link' => 'nullable|url'
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
            if ($banner->image && file_exists(public_path('assets/images/' . $banner->image))) {
                @unlink(public_path('assets/images/' . $banner->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/banners'), $filename);
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

        if ($banner->image && file_exists(public_path('assets/images/' . $banner->image))) {
            @unlink(public_path('assets/images/' . $banner->image));
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