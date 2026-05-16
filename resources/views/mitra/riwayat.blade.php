<x-dashboard-layout title="Riwayat" section_title="Riwayat Pengambilan" role="mitra">
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Riwayat Semua Pengambilan</h3>
        
        @if($riwayat->isEmpty())
            <div class="text-center py-12">
                <svg class="w-20 h-20 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-slate-500 text-lg">Belum ada riwayat pengambilan</p>
                <p class="text-slate-400 text-sm mt-2">Ambil tugas pertama Anda untuk mulai bekerja!</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700">Tanggal</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700">Kontributor</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700">Kategori</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700">Berat</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700">Status</th>
                            <th class="text-right py-3 px-4 text-sm font-semibold text-slate-700">Estimasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $item)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-sm text-slate-600">
                                    {{ $item->created_at->format('d M Y') }}
                                    <br>
                                    <span class="text-xs text-slate-400">{{ $item->created_at->format('H:i') }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-medium text-slate-800">{{ $item->user->name }}</div>
                                    @if($item->user->phone)
                                        <div class="text-xs text-slate-500">{{ $item->user->phone }}</div>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-medium text-slate-800">{{ $item->kategori }}</div>
                                    @if($item->catatan)
                                        <div class="text-xs text-slate-500 mt-1">{{ Str::limit($item->catatan, 30) }}</div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-sm text-slate-700 font-bold">{{ $item->berat }} kg</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        @if($item->status === 'diambil') bg-blue-100 text-blue-700
                                        @elseif($item->status === 'diproses') bg-purple-100 text-purple-700
                                        @elseif($item->status === 'selesai') bg-green-100 text-green-700
                                        @else bg-red-100 text-red-700
                                        @endif">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    @if($item->status === 'selesai')
                                        <span class="text-emerald-600 font-bold">Rp {{ number_format($item->berat * 5000, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-slate-400 font-semibold">Rp {{ number_format($item->berat * 5000, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="mt-6 pt-6 border-t border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-slate-50 rounded-lg p-4">
                        <p class="text-sm text-slate-600 mb-1">Total Tugas</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $riwayat->count() }}</p>
                    </div>
                    <div class="bg-emerald-50 rounded-lg p-4">
                        <p class="text-sm text-emerald-600 mb-1">Selesai</p>
                        <p class="text-2xl font-bold text-emerald-700">{{ $riwayat->where('status', 'selesai')->count() }}</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-sm text-blue-600 mb-1">Total Berat</p>
                        <p class="text-2xl font-bold text-blue-700">{{ number_format($riwayat->where('status', 'selesai')->sum('berat'), 1) }} kg</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4">
                        <p class="text-sm text-purple-600 mb-1">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-purple-700">Rp {{ number_format($riwayat->where('status', 'selesai')->sum('berat') * 5000, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-dashboard-layout>
