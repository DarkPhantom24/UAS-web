<x-dashboard-layout title="Dashboard Mitra" section_title="Dashboard Mitra" role="mitra">
    <div class="space-y-6 max-w-2xl mx-auto lg:max-w-none">

        @if(session('success'))
        <div class="bg-ewaste-50 border border-ewaste-300 text-ewaste-700 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>
        @endif

        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <div class="stat-card animate-fade-in-up">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-ewaste-100 flex items-center justify-center"><i class="ph-fill ph-package text-lg text-ewaste-600"></i></div>
                    <div><p class="text-xs text-slate-500">Order Selesai</p><p class="text-xl font-extrabold text-slate-800">{{ $totalSelesai }}</p></div>
                </div>
            </div>
            <div class="stat-card animate-fade-in-up animation-delay-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center"><i class="ph-fill ph-scales text-lg text-blue-600"></i></div>
                    <div><p class="text-xs text-slate-500">Total Berat</p><p class="text-xl font-extrabold text-slate-800">{{ number_format($totalBerat, 1) }} kg</p></div>
                </div>
            </div>
            <div class="stat-card animate-fade-in-up animation-delay-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center"><i class="ph-fill ph-clock text-lg text-amber-600"></i></div>
                    <div><p class="text-xs text-slate-500">Order Aktif</p><p class="text-xl font-extrabold text-slate-800">{{ $orderAktif->count() }}</p></div>
                </div>
            </div>
        </div>

        {{-- Order Aktif --}}
        @if($orderAktif->count() > 0)
        <div>
            <h2 class="font-bold text-lg text-slate-800 mb-4">Order Aktif Saya</h2>
            <div class="space-y-3">
                @foreach($orderAktif as $order)
                <div class="bg-white rounded-2xl border border-ewaste-100 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="badge-info"><i class="ph ph-truck text-xs"></i> {{ ucfirst($order->status) }}</span>
                                <span class="text-xs text-slate-400 font-mono">#REQ-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <h3 class="font-semibold text-slate-800">{{ $order->kategori }}</h3>
                            <p class="text-sm text-slate-500 mt-1"><i class="ph ph-map-pin text-ewaste-500"></i> {{ $order->alamat }}</p>
                            <div class="flex items-center gap-4 mt-2 text-xs text-slate-400">
                                <span><i class="ph ph-scales text-sm"></i> {{ $order->berat }} kg</span>
                                <span><i class="ph ph-user text-sm"></i> {{ $order->user->name ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="shrink-0 flex flex-col gap-2">
                            @if($order->status === 'diambil')
                            <form action="{{ route('mitra.status', $order) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="diproses">
                                <button class="btn-primary !py-2 !px-3 !text-xs w-full"><i class="ph ph-arrow-right text-sm"></i> Proses</button>
                            </form>
                            @endif
                            @if($order->status === 'diproses')
                            <form action="{{ route('mitra.status', $order) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="selesai">
                                <button class="btn-primary !py-2 !px-3 !text-xs w-full"><i class="ph ph-check-circle text-sm"></i> Selesai</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Tugas Tersedia --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-lg text-slate-800">Tugas Tersedia</h2>
                <span class="text-xs text-ewaste-600 font-semibold bg-ewaste-50 px-3 py-1 rounded-full">{{ $tugasTersedia->count() }} tersedia</span>
            </div>

            <div class="space-y-3">
                @forelse($tugasTersedia as $tugas)
                <div class="bg-white rounded-2xl border border-slate-100 p-5 hover:shadow-lg hover:shadow-slate-200/50 transition-all duration-300">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="badge-warning"><i class="ph ph-clock text-xs"></i> Menunggu</span>
                                <span class="text-xs text-slate-400 font-mono">#REQ-{{ str_pad($tugas->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <h3 class="font-semibold text-slate-800">{{ $tugas->kategori }}</h3>
                            <p class="text-sm text-slate-500 mt-1"><i class="ph ph-map-pin text-ewaste-500"></i> {{ $tugas->alamat }}</p>
                            <div class="flex items-center gap-4 mt-2 text-xs text-slate-400">
                                <span><i class="ph ph-scales text-sm"></i> {{ $tugas->berat }} kg</span>
                                <span><i class="ph ph-user text-sm"></i> {{ $tugas->user->name ?? '-' }}</span>
                                <span><i class="ph ph-calendar text-sm"></i> {{ $tugas->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="shrink-0">
                            <form action="{{ route('mitra.ambil', $tugas) }}" method="POST">
                                @csrf
                                <button class="btn-primary !py-2 !px-4 !text-xs"><i class="ph ph-check-circle text-sm"></i> Ambil Order</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-2xl border border-slate-100 p-8 text-center">
                    <i class="ph ph-clipboard-text text-4xl text-slate-200 block mb-2"></i>
                    <p class="text-sm text-slate-400">Belum ada tugas yang tersedia saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- QR Code Scanner --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 text-center">
            <div class="w-20 h-20 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                <i class="ph ph-qr-code text-4xl text-slate-400"></i>
            </div>
            <h3 class="font-bold text-slate-800 mb-1">Scan QR Code</h3>
            <p class="text-sm text-slate-500 mb-4">Verifikasi transaksi dengan memindai kode QR dari kontributor</p>
            <a href="{{ route('mitra.scan') }}" class="btn-primary !text-sm"><i class="ph ph-camera text-lg"></i> Buka Kamera</a>
        </div>
    </div>
</x-dashboard-layout>
