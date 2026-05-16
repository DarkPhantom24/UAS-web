<x-guest-layout title="Beranda">
    {{-- ═══ HERO SECTION ═══ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-white to-ewaste-50/30">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-ewaste-200/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute -bottom-40 -left-40 w-[400px] h-[400px] bg-ewaste-100/30 rounded-full blur-3xl animate-float animation-delay-200"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 lg:py-36">
            <div class="max-w-3xl mx-auto text-center animate-fade-in-up">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-ewaste-50 text-ewaste-700 rounded-full text-xs font-semibold mb-6 border border-ewaste-200">
                    <i class="ph-fill ph-leaf text-sm"></i>
                    Platform Daur Ulang #1 di Indonesia
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight tracking-tight">
                    Ubah Sampah Elektronik Jadi <span class="text-transparent bg-clip-text bg-gradient-to-r from-ewaste-500 to-ewaste-700">Cuan</span> & Selamatkan <span class="text-transparent bg-clip-text bg-gradient-to-r from-ewaste-600 to-emerald-500">Bumi</span>
                </h1>
                <p class="mt-6 text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed">
                    Hubungkan sampah elektronik Anda dengan mitra pengepul terverifikasi dan pabrik daur ulang profesional. Dapatkan poin reward sambil berkontribusi untuk lingkungan.
                </p>
                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('auth.register') }}" class="btn-primary !px-8 !py-3.5 !text-base shadow-xl shadow-ewaste-500/20">
                        <i class="ph ph-rocket-launch text-xl"></i>
                        Mulai Sekarang
                    </a>
                    <a href="#dropoff" class="btn-secondary !px-8 !py-3.5 !text-base">
                        <i class="ph ph-map-pin text-xl"></i>
                        Cari Titik Drop-off
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 animate-fade-in-up animation-delay-300">
                <div class="text-center p-4 sm:p-6 bg-white/80 rounded-2xl border border-slate-100 glow-emerald">
                    <div class="text-2xl sm:text-3xl font-extrabold text-ewaste-600">12.5<span class="text-lg">T</span></div>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Sampah Terkelola</p>
                </div>
                <div class="text-center p-4 sm:p-6 bg-white/80 rounded-2xl border border-slate-100">
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">1,240+</div>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Mitra Aktif</p>
                </div>
                <div class="text-center p-4 sm:p-6 bg-white/80 rounded-2xl border border-slate-100">
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">50K+</div>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Pengguna Terdaftar</p>
                </div>
                <div class="text-center p-4 sm:p-6 bg-white/80 rounded-2xl border border-slate-100">
                    <div class="text-2xl sm:text-3xl font-extrabold text-ewaste-600">98%</div>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Tingkat Kepuasan</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ HOW IT WORKS ═══ --}}
    <section id="tentang" class="py-20 sm:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="text-ewaste-600 font-semibold text-sm mb-2">Cara Kerja</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Semudah 3 Langkah</h2>
                <p class="mt-4 text-slate-500 max-w-xl mx-auto">Proses yang simpel dan transparan untuk mengelola sampah elektronik Anda.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="relative group">
                    <div class="absolute -top-3 -left-3 w-10 h-10 bg-ewaste-500 text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-lg shadow-ewaste-500/30 group-hover:scale-110 transition-transform">1</div>
                    <div class="bg-slate-50 rounded-2xl p-8 pt-10 border border-slate-100 group-hover:shadow-xl group-hover:shadow-slate-200/50 transition-all duration-300">
                        <div class="w-14 h-14 bg-ewaste-100 rounded-xl flex items-center justify-center mb-5"><i class="ph ph-camera text-2xl text-ewaste-600"></i></div>
                        <h3 class="font-bold text-lg text-slate-800 mb-2">Foto & Kirim Request</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Ambil foto barang elektronik bekas, pilih kategori, dan buat request penjemputan.</p>
                    </div>
                </div>
                <div class="relative group">
                    <div class="absolute -top-3 -left-3 w-10 h-10 bg-ewaste-500 text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-lg shadow-ewaste-500/30 group-hover:scale-110 transition-transform">2</div>
                    <div class="bg-slate-50 rounded-2xl p-8 pt-10 border border-slate-100 group-hover:shadow-xl group-hover:shadow-slate-200/50 transition-all duration-300">
                        <div class="w-14 h-14 bg-ewaste-100 rounded-xl flex items-center justify-center mb-5"><i class="ph ph-truck text-2xl text-ewaste-600"></i></div>
                        <h3 class="font-bold text-lg text-slate-800 mb-2">Mitra Jemput</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Mitra pengepul terdekat akan menerima notifikasi dan menjemput barang Anda.</p>
                    </div>
                </div>
                <div class="relative group">
                    <div class="absolute -top-3 -left-3 w-10 h-10 bg-ewaste-500 text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-lg shadow-ewaste-500/30 group-hover:scale-110 transition-transform">3</div>
                    <div class="bg-slate-50 rounded-2xl p-8 pt-10 border border-slate-100 group-hover:shadow-xl group-hover:shadow-slate-200/50 transition-all duration-300">
                        <div class="w-14 h-14 bg-ewaste-100 rounded-xl flex items-center justify-center mb-5"><i class="ph ph-coins text-2xl text-ewaste-600"></i></div>
                        <h3 class="font-bold text-lg text-slate-800 mb-2">Dapat Poin & Cuan</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Dapatkan poin reward yang bisa ditukar saldo. Jejak kontribusi Anda tercatat!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ DROP-OFF CENTERS (GRID) ═══ --}}
    <section id="dropoff" class="py-20 sm:py-28 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-ewaste-600 font-semibold text-sm mb-2">Lokasi Kami</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Daftar Titik Drop-off</h2>
                <p class="mt-4 text-slate-500 max-w-xl mx-auto">Temukan lokasi drop-off terdekat untuk menyerahkan sampah elektronik Anda.</p>
            </div>

            {{-- Search --}}
            <div class="max-w-xl mx-auto mb-12">
                <div class="relative">
                    <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                    <input type="text" placeholder="Cari Titik Drop-off Terdekat" class="input-ewaste !pl-12 !py-4 !rounded-2xl !bg-white shadow-lg shadow-slate-200/50 !border-slate-200/80">
                </div>
            </div>

            {{-- Grid Cards --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Card 1 --}}
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group">
                    <div class="h-2 bg-gradient-to-r from-ewaste-400 to-ewaste-600"></div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-ewaste-100 flex items-center justify-center shrink-0 group-hover:bg-ewaste-500 group-hover:text-white transition-colors"><i class="ph ph-map-pin text-xl text-ewaste-600 group-hover:text-white"></i></div>
                            <div>
                                <h3 class="font-bold text-slate-800">TPS3R Cakung Timur</h3>
                                <p class="text-sm text-slate-500 mt-0.5">Jl. Raya Cakung No. 45, Jakarta Timur</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500"><i class="ph ph-clock text-base"></i> Senin - Sabtu, 08:00 - 17:00 WIB</div>
                        <a href="https://maps.google.com/?q=TPS3R+Cakung+Timur+Jakarta" target="_blank" rel="noopener" class="btn-primary w-full !text-xs !py-2.5">
                            <i class="ph ph-navigation-arrow text-sm"></i> Lihat Rute di Google Maps
                        </a>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group">
                    <div class="h-2 bg-gradient-to-r from-ewaste-400 to-ewaste-600"></div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-ewaste-100 flex items-center justify-center shrink-0 group-hover:bg-ewaste-500 group-hover:text-white transition-colors"><i class="ph ph-map-pin text-xl text-ewaste-600 group-hover:text-white"></i></div>
                            <div>
                                <h3 class="font-bold text-slate-800">Depo Daur Ulang Tangerang</h3>
                                <p class="text-sm text-slate-500 mt-0.5">Jl. MH Thamrin No. 12, Kota Tangerang</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500"><i class="ph ph-clock text-base"></i> Senin - Jumat, 09:00 - 16:00 WIB</div>
                        <a href="https://maps.google.com/?q=Depo+Daur+Ulang+Tangerang" target="_blank" rel="noopener" class="btn-primary w-full !text-xs !py-2.5">
                            <i class="ph ph-navigation-arrow text-sm"></i> Lihat Rute di Google Maps
                        </a>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group">
                    <div class="h-2 bg-gradient-to-r from-ewaste-400 to-ewaste-600"></div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-ewaste-100 flex items-center justify-center shrink-0 group-hover:bg-ewaste-500 group-hover:text-white transition-colors"><i class="ph ph-map-pin text-xl text-ewaste-600 group-hover:text-white"></i></div>
                            <div>
                                <h3 class="font-bold text-slate-800">Bank Sampah Elektronik Depok</h3>
                                <p class="text-sm text-slate-500 mt-0.5">Jl. Margonda Raya No. 88, Depok</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500"><i class="ph ph-clock text-base"></i> Selasa - Minggu, 08:00 - 15:00 WIB</div>
                        <a href="https://maps.google.com/?q=Bank+Sampah+Elektronik+Depok" target="_blank" rel="noopener" class="btn-primary w-full !text-xs !py-2.5">
                            <i class="ph ph-navigation-arrow text-sm"></i> Lihat Rute di Google Maps
                        </a>
                    </div>
                </div>

                {{-- Card 4 --}}
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group">
                    <div class="h-2 bg-gradient-to-r from-ewaste-400 to-ewaste-600"></div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-ewaste-100 flex items-center justify-center shrink-0 group-hover:bg-ewaste-500 group-hover:text-white transition-colors"><i class="ph ph-map-pin text-xl text-ewaste-600 group-hover:text-white"></i></div>
                            <div>
                                <h3 class="font-bold text-slate-800">Pusat E-Waste Bandung</h3>
                                <p class="text-sm text-slate-500 mt-0.5">Jl. Dago No. 150, Bandung</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500"><i class="ph ph-clock text-base"></i> Senin - Sabtu, 07:30 - 16:30 WIB</div>
                        <a href="https://maps.google.com/?q=Pusat+E-Waste+Bandung+Dago" target="_blank" rel="noopener" class="btn-primary w-full !text-xs !py-2.5">
                            <i class="ph ph-navigation-arrow text-sm"></i> Lihat Rute di Google Maps
                        </a>
                    </div>
                </div>

                {{-- Card 5 --}}
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group">
                    <div class="h-2 bg-gradient-to-r from-ewaste-400 to-ewaste-600"></div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-ewaste-100 flex items-center justify-center shrink-0 group-hover:bg-ewaste-500 group-hover:text-white transition-colors"><i class="ph ph-map-pin text-xl text-ewaste-600 group-hover:text-white"></i></div>
                            <div>
                                <h3 class="font-bold text-slate-800">Recycling Center Surabaya</h3>
                                <p class="text-sm text-slate-500 mt-0.5">Jl. Pemuda No. 33, Surabaya</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500"><i class="ph ph-clock text-base"></i> Senin - Jumat, 08:00 - 17:00 WIB</div>
                        <a href="https://maps.google.com/?q=Recycling+Center+Surabaya+Pemuda" target="_blank" rel="noopener" class="btn-primary w-full !text-xs !py-2.5">
                            <i class="ph ph-navigation-arrow text-sm"></i> Lihat Rute di Google Maps
                        </a>
                    </div>
                </div>

                {{-- Card 6 --}}
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group">
                    <div class="h-2 bg-gradient-to-r from-ewaste-400 to-ewaste-600"></div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-ewaste-100 flex items-center justify-center shrink-0 group-hover:bg-ewaste-500 group-hover:text-white transition-colors"><i class="ph ph-map-pin text-xl text-ewaste-600 group-hover:text-white"></i></div>
                            <div>
                                <h3 class="font-bold text-slate-800">Green Tech Semarang</h3>
                                <p class="text-sm text-slate-500 mt-0.5">Jl. Pandanaran No. 77, Semarang</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500"><i class="ph ph-clock text-base"></i> Senin - Sabtu, 08:30 - 16:00 WIB</div>
                        <a href="https://maps.google.com/?q=Green+Tech+Semarang+Pandanaran" target="_blank" rel="noopener" class="btn-primary w-full !text-xs !py-2.5">
                            <i class="ph ph-navigation-arrow text-sm"></i> Lihat Rute di Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CTA SECTION ═══ --}}
    <section class="py-20 sm:py-28 bg-gradient-to-br from-ewaste-600 to-ewaste-800 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-60 h-60 bg-white/5 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">Siap Berkontribusi untuk Bumi?</h2>
            <p class="text-ewaste-100 text-lg mb-10 max-w-2xl mx-auto">Bergabung bersama ribuan kontributor dan mitra pengepul dalam misi daur ulang sampah elektronik yang lebih baik.</p>
            <a href="{{ route('auth.register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-ewaste-700 font-bold rounded-xl text-base hover:bg-slate-50 shadow-xl shadow-black/10 transition-all duration-200 hover:scale-[1.02]">
                <i class="ph ph-user-plus text-xl"></i>
                Daftar Gratis Sekarang
            </a>
        </div>
    </section>
</x-guest-layout>
