<?php

// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->paginate(20);
        return view('admin.users.index', compact('students'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email',
            'phone'  => 'nullable|string|max:20',
            'active' => 'nullable|boolean',
        ]);

        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ]);

        // contoh nonaktifkan akun: bisa pakai kolom status sendiri jika mau
        // misal jika kamu punya kolom 'is_active'
        // $user->is_active = $data['active'] ?? 0;
        // $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data user diperbarui.');
    }
}

