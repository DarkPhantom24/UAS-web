<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\View\View;

// ═══ PUBLIC (Unauthenticated) ═══
Route::get('/', function (): View {
    return view('welcome');
})->name('landing');

// ═══ AUTH ROUTES ═══
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'store'])->name('auth.store');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// ═══ PROTECTED ROUTES ═══
Route::middleware('auth')->group(function () {

    // ── User (Masyarakat) — hanya role masyarakat ──
    Route::middleware('role:masyarakat')->group(function () {
        Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
        Route::get('/user/request', [DashboardController::class, 'userRequest'])->name('user.request');
        Route::post('/user/request', [DashboardController::class, 'userStoreRequest'])->name('user.request.store');
        Route::get('/user/riwayat', [DashboardController::class, 'userRiwayat'])->name('user.riwayat');
        Route::get('/user/poin', [DashboardController::class, 'userPoin'])->name('user.poin');
    });

    // ── Mitra (Pengepul / Bos Lapak) — hanya role mitra ──
    Route::middleware('role:mitra')->group(function () {
        Route::get('/mitra/dashboard', [DashboardController::class, 'mitraDashboard'])->name('mitra.dashboard');
        Route::get('/mitra/tugas', [DashboardController::class, 'mitraTugas'])->name('mitra.tugas');
        Route::post('/mitra/ambil/{ewasteRequest}', [DashboardController::class, 'mitraAmbilOrder'])->name('mitra.ambil');
        Route::put('/mitra/status/{ewasteRequest}', [DashboardController::class, 'mitraUpdateStatus'])->name('mitra.status');
        Route::get('/mitra/riwayat', [DashboardController::class, 'mitraRiwayat'])->name('mitra.riwayat');
        Route::get('/mitra/scan', [DashboardController::class, 'mitraScan'])->name('mitra.scan');
    });

    // ── Admin (Kelompok 4) — hanya role admin ──
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/admin/transaksi', [DashboardController::class, 'adminTransaksi'])->name('admin.transaksi');
        Route::get('/admin/pengguna', [DashboardController::class, 'adminPengguna'])->name('admin.pengguna');
        Route::put('/admin/pengguna/{user}/approve', [DashboardController::class, 'adminApproveMitra'])->name('admin.pengguna.approve');
        Route::delete('/admin/pengguna/{user}/reject', [DashboardController::class, 'adminRejectMitra'])->name('admin.pengguna.reject');
        Route::post('/admin/pengguna/smart-review', [DashboardController::class, 'adminSmartReviewMitra'])->name('admin.pengguna.smart-review');
        Route::get('/admin/laporan', [DashboardController::class, 'adminLaporan'])->name('admin.laporan');
        Route::get('/admin/pengaturan', [DashboardController::class, 'adminPengaturan'])->name('admin.pengaturan');
        
        // Category CRUD
        Route::post('/admin/category', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::put('/admin/category/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/admin/category/{category}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    });
});
