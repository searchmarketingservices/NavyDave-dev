<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
 public function index()
 {  $settings = Setting::all();
     return view('dashboard.admin.setting.index', compact('settings'));
 }
 public function create()
 {
     return view('dashboard.admin.setting.create');
 }
 public function store(Request $request)
 {
    $validated = $request->validate([
        'app_name' => 'required|string|max:150',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4048',
        'phone' => 'required|string|max:20',
        'location' => 'nullable|string|max:255',
        'email' => 'required|email|max:100',
        'copyright' => 'required|string',
        'facebook_link' => 'nullable|url|max:255',
        'twitter_link' => 'nullable|url|max:255',
        'instagram_link' => 'nullable|url|max:255',
    ]);

    if ($request->hasFile('logo')) {
        // $logoPath = $request->file('logo')->store('public/logo');
        // $finalPath = explode('public/', $logoPath)[1];
        // $validated['logo'] = $finalPath;

        $extension = $request->file('logo')->getClientOriginalExtension();
        $uniqueName = 'setting' . Str::random(40) . '.' . $extension;
        $request->file('logo')->storeAs('public', $uniqueName);
        $validated['logo'] = $uniqueName;
    }else{
       // Use the default logo
        $defaultlogoPath = 'assets/images/default-user.webp';
        // Store the default logo in the public storage
        $uniqueName = 'staff/default-user.webp';
        Storage::disk('public')->copy($defaultlogoPath, $uniqueName);
        $validated['logo'] = $uniqueName;
    }

    Setting::create($validated);

    return redirect()->route('admin.setting')->with('success', 'Setting created successfully!');
 }

 public function edit($id)
 {
     $setting = Setting::findOrFail($id);
     return view('dashboard.admin.setting.create', compact('setting'));
 }

 public function update(Request $request, $id)
 {
     $validated = $request->validate([
         'app_name' => 'required|string|max:150',
         'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4048',
         'phone' => 'required|string|max:20',
         'location' => 'nullable|string|max:255',
         'email' => 'required|email|max:100',
         'copyright' => 'required|string',
         'facebook_link' => 'nullable|url|max:255',
         'twitter_link' => 'nullable|url|max:255',
         'instagram_link' => 'nullable|url|max:255',
     ]);

     $setting = Setting::findOrFail($id);

     if ($request->hasFile('logo')) {
        //  $logoPath = $request->file('logo')->store('public/logo');
        //  $finalPath = explode('public/', $logoPath)[1];
        //  $validated['logo'] = $finalPath;

        $extension = $request->file('logo')->getClientOriginalExtension();
        $uniqueName = 'setting' . Str::random(40) . '.' . $extension;
        $request->file('logo')->storeAs('public', $uniqueName);
        $validated['logo'] = $uniqueName;
     }

     $setting->update($validated);

     return redirect()->route('admin.setting')->with('success', 'Setting updated successfully!');
 }

}
