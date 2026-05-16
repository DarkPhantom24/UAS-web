<x-dashboard-layout title="Scan QR Code" section_title="Scan QR Code" role="mitra">
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <!-- Scanner Area -->
        <div class="max-w-md mx-auto">
            <div class="text-center mb-6">
                <div class="w-24 h-24 mx-auto bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-4 shadow-lg">
                    <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-800 text-xl mb-2">Verifikasi Transaksi</h3>
                <p class="text-sm text-slate-500">Scan kode QR dari kontributor untuk memverifikasi pengambilan barang</p>
            </div>

            <!-- QR Scanner Placeholder -->
            <div class="bg-slate-100 rounded-2xl p-8 mb-6 border-4 border-dashed border-slate-300">
                <div class="aspect-square bg-white rounded-xl flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-32 h-32 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <p class="text-slate-400 text-sm">Area Scanner QR Code</p>
                    </div>
                </div>
            </div>

            <button onclick="alert('Fitur scan QR code akan segera tersedia!')" class="w-full px-6 py-3 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors font-semibold text-lg shadow-lg hover:shadow-xl">
                <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Buka Kamera
            </button>
        </div>
    </div>

    <!-- Cara Penggunaan -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 mt-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">📱 Cara Menggunakan</h3>
        <div class="space-y-3">
            <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg">
                <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                <div>
                    <h4 class="font-semibold text-slate-800">Ambil Tugas</h4>
                    <p class="text-sm text-slate-600">Pilih dan ambil tugas dari daftar tugas tersedia</p>
                </div>
            </div>
            <div class="flex items-start gap-3 p-3 bg-purple-50 rounded-lg">
                <div class="w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                <div>
                    <h4 class="font-semibold text-slate-800">Datang ke Lokasi</h4>
                    <p class="text-sm text-slate-600">Kunjungi alamat kontributor untuk mengambil e-waste</p>
                </div>
            </div>
            <div class="flex items-start gap-3 p-3 bg-emerald-50 rounded-lg">
                <div class="w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                <div>
                    <h4 class="font-semibold text-slate-800">Scan QR Code</h4>
                    <p class="text-sm text-slate-600">Minta kontributor menunjukkan QR code dan scan untuk verifikasi</p>
                </div>
            </div>
            <div class="flex items-start gap-3 p-3 bg-amber-50 rounded-lg">
                <div class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                <div>
                    <h4 class="font-semibold text-slate-800">Selesaikan Transaksi</h4>
                    <p class="text-sm text-slate-600">Update status menjadi "Selesai" setelah barang diambil</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mt-6">
        <div class="flex gap-3">
            <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="text-sm text-blue-800 font-medium mb-1">Informasi Penting</p>
                <p class="text-sm text-blue-700">Fitur scan QR code sedang dalam pengembangan. Saat ini Anda dapat mengupdate status transaksi secara manual dari dashboard.</p>
            </div>
        </div>
    </div>
</x-dashboard-layout>
