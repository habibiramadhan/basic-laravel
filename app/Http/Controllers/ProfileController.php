<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
        ], [
            'name.required' => 'Username wajib diisi',
            'name.unique' => 'Username sudah digunakan, pilih username lain',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan, gunakan email lain',
            'no_telepon.required' => 'Nomor telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
        ]);
        
        $user->update($validated);
        
        // Redirect berdasarkan role
        $redirectRoute = $user->isAdmin() ? 'admin.dashboard' : 'customer.dashboard';
        
        return redirect()->route($redirectRoute)->with('success', 'Profile berhasil diperbarui!');
    }
    
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);
        
        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak benar']);
        }
        
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);
        
        // Redirect berdasarkan role
        $redirectRoute = $user->isAdmin() ? 'admin.dashboard' : 'customer.dashboard';
        
        return redirect()->route($redirectRoute)->with('success', 'Password berhasil diperbarui!');
    }
}