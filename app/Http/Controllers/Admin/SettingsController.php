<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingsRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit');
    }

    public function update(UpdateSettingsRequest $request)
    {
        $data = $request->validated();

        $pairs = [];

        // Flatten nested input back to dot-notation keys
        foreach ($data['hero']   ?? [] as $k => $v) { $pairs["hero.{$k}"]   = $v; }
        foreach ($data['about']  ?? [] as $k => $v) { $pairs["about.{$k}"]  = $v; }
        foreach ($data['cta']    ?? [] as $k => $v) { $pairs["cta.{$k}"]    = $v; }
        foreach ($data['footer'] ?? [] as $k => $v) {
            if ($k === 'social' && is_array($v)) {
                foreach ($v as $sk => $sv) { $pairs["footer.social.{$sk}"] = $sv; }
            } else {
                $pairs["footer.{$k}"] = $v;
            }
        }

        // Handle image uploads
        foreach ([
            'hero_image'  => 'hero.image_path',
            'about_image' => 'about.image_path',
        ] as $field => $settingKey) {
            if ($request->hasFile($field)) {
                // Remove previous file, if any
                $old = Setting::get($settingKey);
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
                $path = $request->file($field)->store('site', 'public');
                $pairs[$settingKey] = $path;
            }
        }

        Setting::setMany($pairs);

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Settings saved.');
    }
}
