<x-dashboard-layout title="Transaksi" section_title="Kelola Transaksi" role="admin">
    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <h3 class="font-bold text-slate-800">Semua Transaksi</h3>
                <p class="text-xs text-slate-400 mt-0.5">Seluruh request e-waste dari masyarakat</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead><tr class="text-xs text-slate-500 border-b border-slate-100 bg-slate-50/80">
                        <th class="text-left py-3 px-5 font-semibold">ID</th>
                        <th class="text-left py-3 px-5 font-semibold">Kontributor</th>
                        <th class="text-left py-3 px-5 font-semibold">Mitra</th>
                        <th class="text-left py-3 px-5 font-semibold">Kategori</th>
                        <th class="text-left py-3 px-5 font-semibold">Berat</th>
                        <th class="text-left py-3 px-5 font-semibold">Alamat</th>
                        <th class="text-left py-3 px-5 font-semibold">Status</th>
                        <th class="text-left py-3 px-5 font-semibold">Tanggal</th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($transaksi as $trx)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3 px-5 text-sm font-mono text-slate-600">#TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-3 px-5 text-sm text-slate-700">{{ $trx->user->name ?? '-' }}</td>
                            <td class="py-3 px-5 text-sm text-slate-700">{{ $trx->mitra->name ?? '-' }}</td>
                            <td class="py-3 px-5 text-sm">{{ $trx->kategori }}</td>
                            <td class="py-3 px-5 text-sm">{{ $trx->berat }} kg</td>
                            <td class="py-3 px-5 text-sm text-slate-500 max-w-[180px] truncate">{{ $trx->alamat }}</td>
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
                            <td class="py-3 px-5 text-sm text-slate-400">{{ $trx->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="py-8 text-center text-sm text-slate-400">Belum ada transaksi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($transaksi->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $transaksi->links() }}</div>
            @endif
        </div>
    </div>
</x-dashboard-layout>
