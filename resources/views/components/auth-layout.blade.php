@props(['title' => 'Autentikasi', 'section_title' => '', 'section_description' => ''])
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Masuk atau daftar ke platform E-Waste Hub.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css" />
    <title>{{ $title }} — E-Waste Hub</title>
</head>

<body class="bg-slate-50 min-h-screen">
    <main class="flex items-center justify-center min-h-screen px-4 py-8 relative overflow-hidden">
        {{-- Background Decorative Elements --}}
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden">
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-ewaste-100/50 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-ewaste-100/30 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-ewaste-50/40 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 w-full max-w-md space-y-6 animate-fade-in-up">
            {{-- Logo --}}
            <div class="flex items-center gap-2.5 justify-center">
                <a href="/" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-ewaste-500 to-ewaste-600 flex items-center justify-center shadow-lg shadow-ewaste-500/20 group-hover:shadow-xl group-hover:shadow-ewaste-500/30 transition-all duration-300">
                        <i class="ph-fill ph-recycle text-white text-xl"></i>
                    </div>
                    <span class="font-bold text-xl text-slate-800">E-Waste<span class="text-ewaste-500">Hub</span></span>
                </a>
            </div>

            {{-- Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xl shadow-slate-200/40 p-8 space-y-6">
                @if($section_title)
                    <div class="space-y-1">
                        <h1 class="font-bold text-2xl text-slate-800">{{ $section_title }}</h1>
                        @if($section_description)
                            <p class="text-slate-500 text-sm">{{ $section_description }}</p>
                        @endif
                    </div>
                    <div class="h-px bg-slate-100"></div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </main>
</body>

</html>
