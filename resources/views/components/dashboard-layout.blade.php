@props(['title' => 'Dashboard', 'section_title' => 'Dashboard', 'role' => 'user'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css" />
    @if($role === 'admin')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    @endif
    <title>{{ $title }} — E-Waste Hub</title>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
    {{-- Overlay --}}
    <div x-show="sidebarOpen" x-on:click="sidebarOpen = false" class="fixed inset-0 bg-black/30 z-40 lg:hidden" x-cloak></div>

    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 flex flex-col lg:translate-x-0 lg:static transition-transform duration-300">
        <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100">
            <a href="/" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-ewaste-500 to-ewaste-600 flex items-center justify-center shadow-md shadow-ewaste-500/20">
                    <i class="ph-fill ph-recycle text-white text-sm"></i>
                </div>
                <span class="font-bold text-slate-800">E-Waste<span class="text-ewaste-500">Hub</span></span>
            </a>
            <button x-on:click="sidebarOpen = false" class="lg:hidden p-1 rounded-lg hover:bg-slate-100 text-slate-400"><i class="ph ph-x text-lg"></i></button>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Menu Utama</p>
            @if($role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-house-simple text-lg"></i> Beranda</a>
            <a href="{{ route('admin.transaksi') }}" class="{{ request()->is('admin/transaksi') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-arrows-left-right text-lg"></i> Transaksi</a>
            <a href="{{ route('admin.pengguna') }}" class="{{ request()->is('admin/pengguna') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-users text-lg"></i> Kelola Pengguna</a>
            <a href="{{ route('admin.laporan') }}" class="{{ request()->is('admin/laporan') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-file-text text-lg"></i> Laporan</a>
            <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 mt-8">Sistem</p>
            <a href="{{ route('admin.pengaturan') }}" class="{{ request()->is('admin/pengaturan') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-gear text-lg"></i> Pengaturan</a>
            @elseif($role === 'mitra')
            <a href="{{ route('mitra.dashboard') }}" class="{{ request()->is('mitra/dashboard') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-house-simple text-lg"></i> Beranda</a>
            <a href="{{ route('mitra.tugas') }}" class="{{ request()->is('mitra/tugas') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-clipboard-text text-lg"></i> Daftar Tugas</a>
            <a href="{{ route('mitra.riwayat') }}" class="{{ request()->is('mitra/riwayat') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-clock-counter-clockwise text-lg"></i> Riwayat</a>
            <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 mt-8">Alat</p>
            <a href="{{ route('mitra.scan') }}" class="{{ request()->is('mitra/scan') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-qr-code text-lg"></i> Scan QR Code</a>
            @else
            <a href="{{ route('user.dashboard') }}" class="{{ request()->is('user/dashboard') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-house-simple text-lg"></i> Beranda</a>
            <a href="{{ route('user.request') }}" class="{{ request()->is('user/request') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-package text-lg"></i> Request Saya</a>
            <a href="{{ route('user.riwayat') }}" class="{{ request()->is('user/riwayat') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-clock-counter-clockwise text-lg"></i> Riwayat</a>
            <a href="{{ route('user.poin') }}" class="{{ request()->is('user/poin') ? 'sidebar-link-active' : 'sidebar-link' }}"><i class="ph ph-trophy text-lg"></i> Poin & Reward</a>
            @endif
        </nav>

        <div class="border-t border-slate-100 p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-ewaste-400 to-ewaste-600 flex items-center justify-center text-white font-bold text-sm">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-700 truncate">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email ?? '' }}</p>
                </div>
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-slate-400 hover:text-red-500 transition-colors cursor-pointer" title="Keluar"><i class="ph ph-sign-out text-lg"></i></button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0">
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button x-on:click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 text-slate-500"><i class="ph ph-list text-xl"></i></button>
                <h1 class="text-lg font-bold text-slate-800">{{ $section_title }}</h1>
            </div>
            <button class="relative p-2 rounded-lg hover:bg-slate-100 text-slate-500"><i class="ph ph-bell text-xl"></i><span class="absolute top-1.5 right-1.5 w-2 h-2 bg-ewaste-500 rounded-full"></span></button>
        </header>
        <main class="flex-1 p-4 lg:p-8">{{ $slot }}</main>
    </div>
</div>
</body>
</html>
