<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ─── Role Gates ─────────────────────────────────────────

        // Admin-only gate
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        // Masyarakat (Kontributor) gate
        Gate::define('masyarakat', function ($user) {
            return $user->role === 'masyarakat';
        });

        // Mitra (Pengepul / Bos Lapak) gate
        Gate::define('mitra', function ($user) {
            return $user->role === 'mitra';
        });

        // ─── Request E-Waste Gates (Masyarakat only) ────────────

        Gate::define('view-request', function ($user) {
            return $user->role === 'masyarakat';
        });

        Gate::define('store-request', function ($user) {
            return $user->role === 'masyarakat';
        });

        Gate::define('edit-request', function ($user) {
            return $user->role === 'masyarakat';
        });

        Gate::define('destroy-request', function ($user) {
            return $user->role === 'masyarakat';
        });

        // ─── Poin & Reward Gates (Masyarakat only) ──────────────

        Gate::define('view-poin', function ($user) {
            return $user->role === 'masyarakat';
        });

        // ─── Tugas / Order Gates (Mitra only) ───────────────────

        Gate::define('view-tugas', function ($user) {
            return $user->role === 'mitra';
        });

        Gate::define('ambil-order', function ($user) {
            return $user->role === 'mitra';
        });

        Gate::define('selesai-order', function ($user) {
            return $user->role === 'mitra';
        });

        // ─── Scan QR Code Gates (Mitra only) ────────────────────

        Gate::define('scan-qr', function ($user) {
            return $user->role === 'mitra';
        });

        // ─── Transaksi Gates (Admin only) ───────────────────────

        Gate::define('view-transaksi', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('edit-transaksi', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('destroy-transaksi', function ($user) {
            return $user->role === 'admin';
        });

        // ─── Kelola Pengguna Gates (Admin only) ─────────────────

        Gate::define('view-pengguna', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('store-pengguna', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('edit-pengguna', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('destroy-pengguna', function ($user) {
            return $user->role === 'admin';
        });

        // ─── Laporan Gates (Admin only) ─────────────────────────

        Gate::define('view-laporan', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('export-laporan', function ($user) {
            return $user->role === 'admin';
        });

        // ─── Pengaturan Sistem Gates (Admin only) ───────────────

        Gate::define('view-pengaturan', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('edit-pengaturan', function ($user) {
            return $user->role === 'admin';
        });
    }
}
