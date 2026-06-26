<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('dashboard.setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $fields = [
            'site_name', 'site_tagline', 'site_description', 'whatsapp_number',
            'whatsapp_greeting', 'address', 'email', 'instagram', 'tiktok',
            'shopee', 'about_text', 'hero_title', 'hero_subtitle'
        ];

        foreach ($fields as $field) {
            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => trim($request->input($field, ''))]
            );
        }

        if ($request->hasFile('about_image')) {
            $request->validate(['about_image' => 'image|mimes:jpeg,png,jpg,webp|max:2048']);
            $oldAbout = Setting::where('key', 'about_image')->first();
            if ($oldAbout && $oldAbout->value && file_exists(public_path('assets/images/' . $oldAbout->value))) {
                @unlink(public_path('assets/images/' . $oldAbout->value));
            }
            $file = $request->file('about_image');
            $filename = 'about_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/about'), $filename);
            Setting::updateOrCreate(['key' => 'about_image'], ['value' => 'about/' . $filename]);
        }

        if ($request->hasFile('cta_image')) {
            $request->validate(['cta_image' => 'image|mimes:jpeg,png,jpg,webp|max:3072']);
            $oldCta = Setting::where('key', 'cta_image')->first();
            if ($oldCta && $oldCta->value && file_exists(public_path('assets/images/' . $oldCta->value))) {
                @unlink(public_path('assets/images/' . $oldCta->value));
            }
            $file = $request->file('cta_image');
            $filename = 'cta_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/cta'), $filename);
            Setting::updateOrCreate(['key' => 'cta_image'], ['value' => 'cta/' . $filename]);
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan toko berhasil diperbarui.');
    }
}