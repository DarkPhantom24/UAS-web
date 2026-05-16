<x-dashboard-layout title="Laporan Sistem" section_title="Laporan Sistem" role="admin">
    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <h3 class="font-bold text-slate-800">Hasil Laporan</h3>
            <p class="text-xs text-slate-400 mt-0.5">Data laporan dari request yang sudah diselesaikan oleh mitra</p>
        </div>

        {{-- Data Grid --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-xs text-slate-500 border-b border-slate-100 bg-slate-50/80">
                            <th class="text-left py-3.5 px-5 font-semibold">No</th>
                            <th class="text-left py-3.5 px-5 font-semibold">ID Transaksi</th>
                            <th class="text-left py-3.5 px-5 font-semibold">Tanggal Selesai</th>
                            <th class="text-left py-3.5 px-5 font-semibold">Kontributor</th>
                            <th class="text-left py-3.5 px-5 font-semibold">Mitra</th>
                            <th class="text-left py-3.5 px-5 font-semibold">Kategori</th>
                            <th class="text-left py-3.5 px-5 font-semibold">Berat</th>
                            <th class="text-left py-3.5 px-5 font-semibold">Alamat</th>
                            <th class="text-left py-3.5 px-5 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($laporan as $index => $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3 px-5 text-sm text-slate-500">{{ $laporan->firstItem() + $index }}</td>
                            <td class="py-3 px-5 text-sm font-mono text-slate-600">#TRX-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-3 px-5 text-sm text-slate-500">{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 px-5 text-sm text-slate-700">{{ $item->user->name ?? '-' }}</td>
                            <td class="py-3 px-5 text-sm text-slate-700">{{ $item->mitra->name ?? '-' }}</td>
                            <td class="py-3 px-5 text-sm text-slate-600">{{ $item->kategori }}</td>
                            <td class="py-3 px-5 text-sm text-slate-600">{{ $item->berat }} kg</td>
                            <td class="py-3 px-5 text-sm text-slate-500 max-w-[200px] truncate">{{ $item->alamat }}</td>
                            <td class="py-3 px-5"><span class="badge-success"><i class="ph-fill ph-check-circle text-xs"></i> Selesai</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="py-12 text-center text-sm text-slate-400">
                            <i class="ph ph-clipboard-text text-4xl text-slate-200 block mb-2"></i>
                            Belum ada laporan. Laporan akan muncul saat mitra menyelesaikan sebuah request.
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($laporan->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $laporan->links() }}
            </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>
