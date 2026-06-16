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

        if ($request->hasFile('logo')) {
            $request->validate(['logo' => 'image|mimes:jpeg,png,jpg,webp|max:2048']);
            $oldLogo = Setting::where('key', 'logo')->first();
            if ($oldLogo && $oldLogo->value && file_exists(public_path('assets/images/' . $oldLogo->value))) {
                @unlink(public_path('assets/images/' . $oldLogo->value));
            }
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/logo'), $filename);
            Setting::updateOrCreate(['key' => 'logo'], ['value' => 'logo/' . $filename]);
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

        return redirect()->route('settings.index')->with('success', 'Pengaturan toko berhasil diperbarui.');
    }
}