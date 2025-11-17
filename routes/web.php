<?php
use App\Http\Controllers\Student\ComplaintController as StudentComplaintController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Services\WhatsAppService;

Route::get('/test-wa', function (WhatsAppService $wa) {
    $wa->send('082292238133', 'Tes koneksi WhatsApp dari Laravel.');
    return 'WA sent (cek HP kamu)';
});
Route::get('/', function () {
    return view('welcome');
});

// auth routes dari Breeze
require __DIR__.'/auth.php';

use Illuminate\Support\Facades\Auth;

// ...

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    // Kalau admin → ke dashboard admin
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    // Kalau mahasiswa → ke daftar keluhan
    if ($user->isStudent()) {
        return redirect()->route('student.complaints.index');
    }

    // fallback kalau ada role lain
    return redirect('/');
})->middleware(['auth'])->name('dashboard');

// ========== STUDENT ==========
Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('complaints', [StudentComplaintController::class, 'index'])->name('complaints.index');
        Route::get('complaints/create', [StudentComplaintController::class, 'create'])->name('complaints.create');
        Route::post('complaints', [StudentComplaintController::class, 'store'])->name('complaints.store');
        Route::get('complaints/{complaint}', [StudentComplaintController::class, 'show'])->name('complaints.show');

        // rating & feedback setelah status selesai
        Route::post('complaints/{complaint}/rate', [StudentComplaintController::class, 'rate'])
            ->name('complaints.rate');
    });

// ========== ADMIN ==========
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);

        // keluhan
        Route::get('complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
        Route::get('complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('complaints.show');

        // update status + tambah catatan + upload bukti
        Route::post('complaints/{complaint}/respond', [AdminComplaintController::class, 'respond'])
            ->name('complaints.respond');

        // Pengaturan WA
        Route::get('settings/whatsapp', [SettingController::class, 'editWhatsApp'])->name('settings.whatsapp.edit');
        Route::post('settings/whatsapp', [SettingController::class, 'updateWhatsApp'])->name('settings.whatsapp.update');
    });
