@props(['title' => 'E-Waste Hub'])
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Platform digital pengelolaan sampah elektronik. Hubungkan kontributor dengan mitra pengepul dan pabrik daur ulang.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css" />
    <title>{{ $title }} — E-Waste Hub</title>
</head>

<body class="bg-white text-slate-800 min-h-screen">
    {{-- Public Navbar --}}
    <nav class="sticky top-0 z-50 glass-card border-b border-slate-100" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-ewaste-500 to-ewaste-600 flex items-center justify-center shadow-md shadow-ewaste-500/20 group-hover:shadow-lg group-hover:shadow-ewaste-500/30 transition-all duration-300">
                        <i class="ph-fill ph-recycle text-white text-lg"></i>
                    </div>
                    <span class="font-bold text-lg text-slate-800">E-Waste<span class="text-ewaste-500">Hub</span></span>
                </a>

                {{-- Desktop Links --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="/" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-ewaste-600 rounded-lg hover:bg-ewaste-50 transition-all duration-200">Beranda</a>
                    <a href="#dropoff" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-ewaste-600 rounded-lg hover:bg-ewaste-50 transition-all duration-200">Titik Drop-off</a>
                    <a href="#tentang" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-ewaste-600 rounded-lg hover:bg-ewaste-50 transition-all duration-200">Tentang</a>
                </div>

                {{-- Auth Buttons --}}
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('auth.login') }}" class="btn-secondary !py-2 !px-4 !text-xs">Masuk</a>
                    <a href="{{ route('auth.register') }}" class="btn-primary !py-2 !px-4 !text-xs">Daftar</a>
                </div>

                {{-- Hamburger --}}
                <button x-on:click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
                    <i class="ph ph-list text-xl"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden border-t border-slate-100 bg-white px-4 pb-4 pt-2 space-y-1" x-cloak>
            <a href="/" class="block px-3 py-2 text-sm font-medium text-slate-600 hover:bg-ewaste-50 rounded-lg">Beranda</a>
            <a href="#dropoff" class="block px-3 py-2 text-sm font-medium text-slate-600 hover:bg-ewaste-50 rounded-lg">Titik Drop-off</a>
            <a href="#tentang" class="block px-3 py-2 text-sm font-medium text-slate-600 hover:bg-ewaste-50 rounded-lg">Tentang</a>
            <div class="pt-3 flex flex-col gap-2">
                <a href="{{ route('auth.login') }}" class="btn-secondary w-full !text-xs">Masuk</a>
                <a href="{{ route('auth.register') }}" class="btn-primary w-full !text-xs">Daftar</a>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-slate-900">
        <div class="py-5">
            <p class="text-slate-400 text-sm text-center">&copy; {{ date('Y') }} E-Waste Hub — Kelompok 4. Hak cipta dilindungi.</p>
        </div>
    </footer>
</body>

</html>
