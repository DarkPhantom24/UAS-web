<x-dashboard-layout title="Dashboard" section_title="Dashboard Saya" role="user">
    <div class="space-y-6" x-data="{ showModal: false, step: 1 }">

        @if(session('success'))
        <div class="bg-ewaste-50 border border-ewaste-300 text-ewaste-700 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>
        @endif

        {{-- Gamification Card --}}
        <div class="grid sm:grid-cols-2 gap-4">
            <div class="stat-card glow-emerald animate-fade-in-up">
                <div class="absolute top-0 right-0 w-32 h-32 bg-ewaste-100/30 rounded-full -translate-y-8 translate-x-8 blur-2xl"></div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-ewaste-400 to-ewaste-600 flex items-center justify-center shadow-lg shadow-ewaste-500/20">
                            <i class="ph-fill ph-trophy text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Total Poin Saya</p>
                            <p class="text-3xl font-extrabold text-slate-800">{{ number_format($totalPoin) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="stat-card animate-fade-in-up animation-delay-100">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-100/30 rounded-full -translate-y-8 translate-x-8 blur-2xl"></div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                            <i class="ph-fill ph-wallet text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Saldo Virtual</p>
                            <p class="text-3xl font-extrabold text-slate-800">Rp {{ number_format($saldo) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Riwayat Request Table --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-slate-100">
                <h2 class="font-bold text-slate-800">Riwayat Request</h2>
                <button x-on:click="showModal = true; step = 1" class="btn-primary !py-2 !px-4 !text-xs cursor-pointer">
                    <i class="ph ph-plus text-sm"></i> Buat Request Baru
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead><tr class="text-xs text-slate-500 border-b border-slate-50 bg-slate-50/50">
                        <th class="text-left py-3 px-5 font-semibold">ID</th>
                        <th class="text-left py-3 px-5 font-semibold">Kategori</th>
                        <th class="text-left py-3 px-5 font-semibold">Berat</th>
                        <th class="text-left py-3 px-5 font-semibold">Tanggal</th>
                        <th class="text-left py-3 px-5 font-semibold">Status</th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($requests as $req)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3 px-5 text-sm font-mono text-slate-600">#REQ-{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-3 px-5 text-sm text-slate-700">{{ $req->kategori }}</td>
                            <td class="py-3 px-5 text-sm text-slate-600">{{ $req->berat }} kg</td>
                            <td class="py-3 px-5 text-sm text-slate-500">{{ $req->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-5">
                                @if($req->status === 'selesai')
                                    <span class="badge-success"><i class="ph-fill ph-check-circle text-xs"></i> Selesai</span>
                                @elseif($req->status === 'dibatalkan')
                                    <span class="badge-danger"><i class="ph-fill ph-x-circle text-xs"></i> Dibatalkan</span>
                                @elseif($req->status === 'menunggu')
                                    <span class="badge-warning"><i class="ph-fill ph-hourglass text-xs"></i> Menunggu</span>
                                @else
                                    <span class="badge-info"><i class="ph-fill ph-truck text-xs"></i> {{ ucfirst($req->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-8 text-center text-sm text-slate-400">Belum ada request. Buat request pertama Anda!</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- FAB (Mobile) --}}
        <button x-on:click="showModal = true; step = 1" class="fixed bottom-6 right-6 z-20 w-14 h-14 bg-gradient-to-br from-ewaste-500 to-ewaste-600 text-white rounded-2xl shadow-xl shadow-ewaste-500/30 flex items-center justify-center hover:scale-110 active:scale-95 transition-transform cursor-pointer animate-pulse-glow lg:hidden">
            <i class="ph ph-plus text-2xl"></i>
        </button>

        {{-- Multi-step Modal --}}
        <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
            <div x-on:click.away="showModal = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden animate-fade-in-up">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-lg text-slate-800">Buat Request Baru</h3>
                    <button x-on:click="showModal = false" class="p-1 rounded-lg hover:bg-slate-100 text-slate-400 cursor-pointer"><i class="ph ph-x text-lg"></i></button>
                </div>

                <form action="{{ route('user.request.store') }}" method="POST">
                    @csrf
                    {{-- Step Indicator --}}
                    <div class="px-6 pt-5">
                        <div class="flex items-center gap-2">
                            <div :class="step >= 1 ? 'bg-ewaste-500 text-white' : 'bg-slate-200 text-slate-500'" class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-colors">1</div>
                            <div :class="step >= 2 ? 'bg-ewaste-300' : 'bg-slate-200'" class="flex-1 h-1 rounded transition-colors"></div>
                            <div :class="step >= 2 ? 'bg-ewaste-500 text-white' : 'bg-slate-200 text-slate-500'" class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-colors">2</div>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        {{-- Step 1 --}}
                        <div x-show="step === 1" class="space-y-4">
                            <p class="text-sm font-semibold text-slate-700">Langkah 1: Detail Barang</p>
                            <div><label class="text-xs font-semibold text-slate-600">Kategori Barang</label>
                                <select name="kategori" class="input-ewaste mt-1" required>
                                    <option value="">Pilih kategori...</option>
                                    <option>Laptop & Komputer</option>
                                    <option>Smartphone</option>
                                    <option>TV & Monitor</option>
                                    <option>Baterai & Aki</option>
                                    <option>Perangkat Jaringan</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>
                            <div><label class="text-xs font-semibold text-slate-600">Perkiraan Berat (kg)</label>
                                <input type="number" step="0.1" min="0.1" name="berat" class="input-ewaste mt-1" placeholder="cth: 2.5" required>
                            </div>
                        </div>
                        {{-- Step 2 --}}
                        <div x-show="step === 2" class="space-y-4">
                            <p class="text-sm font-semibold text-slate-700">Langkah 2: Lokasi Penjemputan</p>
                            <div><label class="text-xs font-semibold text-slate-600">Alamat Lengkap</label>
                                <textarea name="alamat" class="input-ewaste mt-1" rows="3" placeholder="Tulis alamat lengkap Anda..." required></textarea>
                            </div>
                            <div><label class="text-xs font-semibold text-slate-600">Catatan Tambahan</label>
                                <input type="text" name="catatan" class="input-ewaste mt-1" placeholder="cth: Dekat gerbang komplek">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        <button type="button" x-show="step > 1" x-on:click="step--" class="btn-secondary !py-2 !px-4 !text-xs"><i class="ph ph-arrow-left text-sm"></i> Kembali</button>
                        <span x-show="step === 1"></span>
                        <button type="button" x-show="step < 2" x-on:click="step++" class="btn-primary !py-2 !px-4 !text-xs">Lanjut <i class="ph ph-arrow-right text-sm"></i></button>
                        <button type="submit" x-show="step === 2" class="btn-primary !py-2 !px-4 !text-xs"><i class="ph ph-paper-plane-tilt text-sm"></i> Kirim Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
