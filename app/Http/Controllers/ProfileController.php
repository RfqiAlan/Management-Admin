<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Controller untuk edit profil user sendiri
class ProfileController extends Controller
{
    // Form edit profil
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    // Update profil (nama, email, phone, password)
    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'                 => ['nullable', 'string', 'max:20'],
            'password'              => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'] ?? null;

        // Update password jika diisi
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
