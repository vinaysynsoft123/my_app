<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::first(); 
        return view('settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'      => 'required|email',
            'mobile'     => 'required|string|max:20',
            'address'    => 'required|string',
            'city'       => 'required|string|max:100',
            'logo'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $settings = Setting::first();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }

            $path = $request->file('logo')->store('logos', 'public');
            $settings->logo = $path;
        }

        $settings->update($request->except('logo'));

        return redirect()->route('settings')
            ->with('success', 'Settings updated successfully!');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }

    public function update_profile(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',         
            'password' => 'nullable|confirmed|min:8',           
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
     
        $user->update($data);

     
        return back()->with('success', 'Profile updated successfully.');
    }

    
}