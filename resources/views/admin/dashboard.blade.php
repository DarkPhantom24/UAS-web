<x-dashboard-layout title="Admin Control Center" section_title="Pusat Kontrol Admin" role="admin">
    <div class="space-y-6">
        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="stat-card animate-fade-in-up">
                <div class="absolute top-0 right-0 w-20 h-20 bg-ewaste-100/40 rounded-full -translate-y-4 translate-x-4 blur-xl"></div>
                <div class="relative flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-ewaste-400 to-ewaste-600 flex items-center justify-center shadow-lg shadow-ewaste-500/20">
                        <i class="ph-fill ph-recycle text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Total Sampah (Kg)</p>
                        <p class="text-2xl font-extrabold text-slate-800">{{ number_format($totalSampah, 1) }}</p>
                    </div>
                </div>
            </div>
            <div class="stat-card animate-fade-in-up animation-delay-100">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-100/40 rounded-full -translate-y-4 translate-x-4 blur-xl"></div>
                <div class="relative flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <i class="ph-fill ph-users text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Mitra Aktif</p>
                        <p class="text-2xl font-extrabold text-slate-800">{{ number_format($mitraAktif) }}</p>
                    </div>
                </div>
            </div>
            <div class="stat-card animate-fade-in-up animation-delay-200">
                <div class="absolute top-0 right-0 w-20 h-20 bg-purple-100/40 rounded-full -translate-y-4 translate-x-4 blur-xl"></div>
                <div class="relative flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-500/20">
                        <i class="ph-fill ph-user-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Total Pengguna</p>
                        <p class="text-2xl font-extrabold text-slate-800">{{ number_format($totalPengguna) }}</p>
                    </div>
                </div>
            </div>
            <div class="stat-card animate-fade-in-up animation-delay-300">
                <div class="absolute top-0 right-0 w-20 h-20 bg-amber-100/40 rounded-full -translate-y-4 translate-x-4 blur-xl"></div>
                <div class="relative flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center shadow-lg shadow-amber-500/20">
                        <i class="ph-fill ph-arrows-left-right text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Transaksi Aktif</p>
                        <p class="text-2xl font-extrabold text-slate-800">{{ number_format($transaksiAktif) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Grid --}}
        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 p-6">
                <div class="mb-6">
                    <h3 class="font-bold text-slate-800">Tren Daur Ulang Bulanan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Data 12 bulan terakhir (dalam Kg)</p>
                </div>
                <div class="relative h-72">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-6">
                <div class="mb-6">
                    <h3 class="font-bold text-slate-800">Kategori Limbah</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Distribusi jenis e-waste</p>
                </div>
                @if($kategoriData->count() > 0)
                <div class="relative h-56 flex items-center justify-center">
                    <canvas id="doughnutChart"></canvas>
                </div>
                <div class="mt-4 space-y-2">
                    @foreach($kategoriData as $kat => $total)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-600">{{ $kat }}</span>
                        <span class="font-semibold text-slate-700">{{ number_format($total, 1) }} kg</span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="h-56 flex items-center justify-center text-sm text-slate-400">Belum ada data</div>
                @endif
            </div>
        </div>

        {{-- Recent Transactions --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-slate-100">
                <h3 class="font-bold text-slate-800">Transaksi Terbaru</h3>
                <a href="{{ route('admin.transaksi') }}" class="text-sm text-ewaste-600 font-semibold hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead><tr class="text-xs text-slate-500 border-b border-slate-50 bg-slate-50/50">
                        <th class="text-left py-3 px-5 font-semibold">ID</th>
                        <th class="text-left py-3 px-5 font-semibold">Kontributor</th>
                        <th class="text-left py-3 px-5 font-semibold">Mitra</th>
                        <th class="text-left py-3 px-5 font-semibold">Kategori</th>
                        <th class="text-left py-3 px-5 font-semibold">Berat</th>
                        <th class="text-left py-3 px-5 font-semibold">Status</th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($transaksiTerbaru as $trx)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-5 text-sm font-mono text-slate-600">#TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-3 px-5 text-sm">{{ $trx->user->name ?? '-' }}</td>
                            <td class="py-3 px-5 text-sm">{{ $trx->mitra->name ?? '-' }}</td>
                            <td class="py-3 px-5 text-sm">{{ $trx->kategori }}</td>
                            <td class="py-3 px-5 text-sm">{{ $trx->berat }} kg</td>
                            <td class="py-3 px-5">
                                @if($trx->status === 'selesai')
                                    <span class="badge-success">Selesai</span>
                                @elseif($trx->status === 'dibatalkan')
                                    <span class="badge-danger">Dibatalkan</span>
                                @elseif($trx->status === 'menunggu')
                                    <span class="badge-warning">Menunggu</span>
                                @else
                                    <span class="badge-info">{{ ucfirst($trx->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="py-8 text-center text-sm text-slate-400">Belum ada transaksi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const gradient = lineCtx.createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.15)');
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Daur Ulang (Kg)',
                    data: @json($chartData),
                    borderColor: '#10B981',
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10B981',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 }, color: '#94a3b8' } },
                    x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#94a3b8' } }
                }
            }
        });

        @if($kategoriData->count() > 0)
        const colors = ['#10B981', '#3B82F6', '#8B5CF6', '#F59E0B', '#EC4899', '#EF4444', '#06B6D4'];
        new Chart(document.getElementById('doughnutChart'), {
            type: 'doughnut',
            data: {
                labels: @json($kategoriData->keys()),
                datasets: [{
                    data: @json($kategoriData->values()),
                    backgroundColor: colors.slice(0, {{ $kategoriData->count() }}),
                    borderWidth: 0, hoverOffset: 8,
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { display: false } } }
        });
        @endif
    });
    </script>
</x-dashboard-layout>
