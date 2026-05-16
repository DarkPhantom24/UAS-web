<x-dashboard-layout title="Poin & Reward" section_title="Poin & Reward" role="user">
    <!-- Saldo & Poin Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Total Poin -->
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold opacity-90">Total Poin</h3>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-4xl font-bold mb-2">{{ number_format($totalPoin, 0) }}</p>
            <p class="text-sm opacity-80">Poin yang terkumpul</p>
        </div>

        <!-- Estimasi Saldo -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold opacity-90">Estimasi Saldo</h3>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <p class="text-4xl font-bold mb-2">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
            <p class="text-sm opacity-80">1 poin = Rp 75</p>
        </div>
    </div>

    <!-- Cara Mendapatkan Poin -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">💡 Cara Mendapatkan Poin</h3>
        <div class="space-y-3">
            <div class="flex items-start gap-3 p-3 bg-emerald-50 rounded-lg">
                <div class="w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                <div>
                    <h4 class="font-semibold text-slate-800">Buat Request E-Waste</h4>
                    <p class="text-sm text-slate-600">Ajukan permintaan penjemputan sampah elektronik Anda</p>
                </div>
            </div>
            <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg">
                <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                <div>
                    <h4 class="font-semibold text-slate-800">Tunggu Mitra Mengambil</h4>
                    <p class="text-sm text-slate-600">Mitra akan datang ke lokasi Anda untuk mengambil e-waste</p>
                </div>
            </div>
            <div class="flex items-start gap-3 p-3 bg-purple-50 rounded-lg">
                <div class="w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                <div>
                    <h4 class="font-semibold text-slate-800">Dapatkan Poin</h4>
                    <p class="text-sm text-slate-600">Setelah selesai, Anda mendapat <strong>100 poin per kg</strong> e-waste</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Konversi Poin -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">🎁 Tukar Poin Anda</h3>
        
        @if($totalPoin > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="border border-slate-200 rounded-lg p-4 text-center hover:border-emerald-400 hover:shadow-md transition-all cursor-pointer">
                    <div class="text-3xl mb-2">💰</div>
                    <h4 class="font-semibold text-slate-800 mb-1">Saldo E-Wallet</h4>
                    <p class="text-sm text-slate-600 mb-3">Transfer ke GoPay, OVO, Dana</p>
                    <p class="text-emerald-600 font-bold">Min. 10.000 poin</p>
                </div>
                <div class="border border-slate-200 rounded-lg p-4 text-center hover:border-emerald-400 hover:shadow-md transition-all cursor-pointer">
                    <div class="text-3xl mb-2">🎫</div>
                    <h4 class="font-semibold text-slate-800 mb-1">Voucher Belanja</h4>
                    <p class="text-sm text-slate-600 mb-3">Tokopedia, Shopee, Grab</p>
                    <p class="text-emerald-600 font-bold">Min. 5.000 poin</p>
                </div>
                <div class="border border-slate-200 rounded-lg p-4 text-center hover:border-emerald-400 hover:shadow-md transition-all cursor-pointer">
                    <div class="text-3xl mb-2">🌳</div>
                    <h4 class="font-semibold text-slate-800 mb-1">Donasi Pohon</h4>
                    <p class="text-sm text-slate-600 mb-3">Tanam pohon untuk lingkungan</p>
                    <p class="text-emerald-600 font-bold">Min. 2.000 poin</p>
                </div>
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                <p class="text-sm text-amber-800">
                    <strong>Info:</strong> Fitur penukaran poin akan segera tersedia. Kumpulkan poin Anda sekarang!
                </p>
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-slate-500 mb-2">Anda belum memiliki poin</p>
                <p class="text-sm text-slate-400">Mulai berkontribusi dengan membuat request e-waste!</p>
                <a href="{{ route('user.request') }}" class="inline-block mt-4 px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                    Buat Request Sekarang
                </a>
            </div>
        @endif
    </div>
</x-dashboard-layout>
