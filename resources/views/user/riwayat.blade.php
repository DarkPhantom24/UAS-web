<x-dashboard-layout title="Riwayat" section_title="Riwayat Transaksi" role="user">
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Riwayat Semua Transaksi</h3>
        
        @if($requests->isEmpty())
            <div class="text-center py-12">
                <svg class="w-20 h-20 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-slate-500 text-lg">Belum ada riwayat transaksi</p>
                <p class="text-slate-400 text-sm mt-2">Buat request pertama Anda untuk mulai berkontribusi!</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700">Tanggal</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700">Kategori</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700">Berat</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700">Status</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700">Mitra</th>
                            <th class="text-right py-3 px-4 text-sm font-semibold text-slate-700">Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-sm text-slate-600">
                                    {{ $req->created_at->format('d M Y') }}
                                    <br>
                                    <span class="text-xs text-slate-400">{{ $req->created_at->format('H:i') }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-medium text-slate-800">{{ $req->kategori }}</div>
                                    @if($req->catatan)
                                        <div class="text-xs text-slate-500 mt-1">{{ Str::limit($req->catatan, 40) }}</div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-sm text-slate-700 font-medium">{{ $req->berat }} kg</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        @if($req->status === 'menunggu') bg-yellow-100 text-yellow-700
                                        @elseif($req->status === 'diambil') bg-blue-100 text-blue-700
                                        @elseif($req->status === 'diproses') bg-purple-100 text-purple-700
                                        @elseif($req->status === 'selesai') bg-green-100 text-green-700
                                        @else bg-red-100 text-red-700
                                        @endif">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-sm text-slate-600">
                                    @if($req->mitra)
                                        <div class="font-medium text-emerald-600">{{ $req->mitra->name }}</div>
                                        @if($req->mitra->nama_lapak)
                                            <div class="text-xs text-slate-400">{{ $req->mitra->nama_lapak }}</div>
                                        @endif
                                    @else
                                        <span class="text-slate-400 italic">Belum ada</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    @if($req->status === 'selesai')
                                        <span class="text-emerald-600 font-semibold">+{{ number_format($req->berat * 100, 0) }}</span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="mt-6 pt-6 border-t border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-slate-50 rounded-lg p-4">
                        <p class="text-sm text-slate-600 mb-1">Total Request</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $requests->count() }}</p>
                    </div>
                    <div class="bg-emerald-50 rounded-lg p-4">
                        <p class="text-sm text-emerald-600 mb-1">Request Selesai</p>
                        <p class="text-2xl font-bold text-emerald-700">{{ $requests->where('status', 'selesai')->count() }}</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-sm text-blue-600 mb-1">Total Berat Terkumpul</p>
                        <p class="text-2xl font-bold text-blue-700">{{ number_format($requests->where('status', 'selesai')->sum('berat'), 1) }} kg</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-dashboard-layout>
