<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('dashboard.setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'         => 'nullable|max:100',
            'site_tagline'      => 'nullable|max:150',
            'site_description'  => 'nullable|max:500',
            'whatsapp_number'   => 'nullable|digits_between:9,15',
            'whatsapp_greeting' => 'nullable|max:300',
            'address'           => 'nullable|max:300',
            'email'             => 'nullable|email|max:100',
            'instagram'         => 'nullable|max:100',
            'tiktok'            => 'nullable|max:100',
            'shopee'            => 'nullable|url|max:300',
            'about_text'        => 'nullable|max:2000',
            'hero_title'        => 'nullable|max:100',
            'hero_subtitle'     => 'nullable|max:200',
            'about_image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cta_image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'whatsapp_number.digits_between' => 'Nomor WhatsApp harus berupa angka 9-15 digit.',
            'email.email'                    => 'Format email tidak valid.',
            'shopee.url'                     => 'URL Shopee harus diawali https://',
            'about_image.image'              => 'File harus berupa gambar.',
            'about_image.max'                => 'Ukuran foto About maksimal 2MB.',
            'cta_image.image'               => 'File harus berupa gambar.',
            'cta_image.max'                 => 'Ukuran foto CTA maksimal 3MB.',
        ]);

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

            $file = $request->file('about_image');
            $filename = 'about_' . time() . '.' . $file->getClientOriginalExtension();

            $destination = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/about';

            if (!file_exists($destination)) {
                mkdir($destination, 0775, true);
            }

            $old = Setting::where('key', 'about_image')->first();

            if ($old && $old->value && file_exists($destination . '/' . basename($old->value))) {
                unlink($destination . '/' . basename($old->value));
            }

            $file->move($destination, $filename);

            Setting::updateOrCreate(
                ['key' => 'about_image'],
                ['value' => 'about/' . $filename]
            );
        }

        if ($request->hasFile('cta_image')) {

            $file = $request->file('cta_image');
            $filename = 'cta_' . time() . '.' . $file->getClientOriginalExtension();

            $destination = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/cta';

            if (!file_exists($destination)) {
                mkdir($destination, 0775, true);
            }

            $old = Setting::where('key', 'cta_image')->first();

            if ($old && $old->value && file_exists($destination . '/' . basename($old->value))) {
                unlink($destination . '/' . basename($old->value));
            }

            $file->move($destination, $filename);

            Setting::updateOrCreate(
                ['key' => 'cta_image'],
                ['value' => 'cta/' . $filename]
            );
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan toko berhasil diperbarui.');
    }
}