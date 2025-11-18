<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user (Admin & Mahasiswa).
     */
    public function index()
    {
        // Mengambil semua user terbaru, bukan hanya mahasiswa
        $users = User::latest()->paginate(10);

        // Pastikan view menerima variabel $users
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form edit user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Menyimpan perubahan data user (termasuk role & password).
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'role'     => 'required|in:admin,student',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // Update data utama
        $user->fill([
            'name'  => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'role'  => $data['role'],
        ]);

        // Update password hanya jika diisi
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus user dari database.
     */
    public function destroy(User $user)
    {
        // Validasi: Admin tidak boleh menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        // Hapus user
        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}