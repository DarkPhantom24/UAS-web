<x-dashboard-layout title="Kelola Pengguna" section_title="Kelola Pengguna" role="admin">
    <div class="space-y-6">

        @if(session('success'))
        <div class="bg-ewaste-50 border border-ewaste-300 text-ewaste-700 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>
        @endif

        {{-- Mitra Pending Approval --}}
        @if($mitraPending->count() > 0)
        <div class="bg-amber-50 border border-amber-200 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-2 px-5 py-4 border-b border-amber-200">
                <i class="ph ph-warning-circle text-amber-600 text-lg"></i>
                <h3 class="font-bold text-amber-800">Mitra Menunggu Persetujuan ({{ $mitraPending->count() }})</h3>
            </div>
            <div class="divide-y divide-amber-100">
                @foreach($mitraPending as $mitra)
                <div class="flex items-center justify-between p-5 gap-4">
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="w-10 h-10 rounded-full bg-amber-200 flex items-center justify-center text-amber-700 font-bold text-sm shrink-0">
                            {{ substr($mitra->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-800 truncate">{{ $mitra->name }}</p>
                            <p class="text-xs text-slate-500">{{ $mitra->email }} · {{ $mitra->phone ?? '-' }}</p>
                            <p class="text-xs text-slate-400 mt-0.5"><i class="ph ph-storefront"></i> {{ $mitra->nama_lapak ?? '-' }} · {{ $mitra->alamat_lapak ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <form action="{{ route('admin.pengguna.approve', $mitra) }}" method="POST">
                            @csrf @method('PUT')
                            <button type="submit" class="btn-primary !py-2 !px-4 !text-xs"><i class="ph ph-check text-sm"></i> Setujui</button>
                        </form>
                        <form action="{{ route('admin.pengguna.reject', $mitra) }}" method="POST" onsubmit="return confirm('Yakin tolak dan hapus mitra ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger !py-2 !px-4 !text-xs"><i class="ph ph-x text-sm"></i> Tolak</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- All Users Table --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <h3 class="font-bold text-slate-800">Semua Pengguna</h3>
                <p class="text-xs text-slate-400 mt-0.5">Daftar seluruh pengguna terdaftar di sistem</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead><tr class="text-xs text-slate-500 border-b border-slate-100 bg-slate-50/80">
                        <th class="text-left py-3 px-5 font-semibold">Nama</th>
                        <th class="text-left py-3 px-5 font-semibold">Email</th>
                        <th class="text-left py-3 px-5 font-semibold">No. Telepon</th>
                        <th class="text-left py-3 px-5 font-semibold">Role</th>
                        <th class="text-left py-3 px-5 font-semibold">Status</th>
                        <th class="text-left py-3 px-5 font-semibold">Terdaftar</th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($semuaPengguna as $pengguna)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-ewaste-400 to-ewaste-600 flex items-center justify-center text-white text-xs font-bold">{{ substr($pengguna->name, 0, 1) }}</div>
                                    <span class="text-sm font-medium text-slate-700">{{ $pengguna->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-5 text-sm text-slate-500">{{ $pengguna->email }}</td>
                            <td class="py-3 px-5 text-sm text-slate-500">{{ $pengguna->phone ?? '-' }}</td>
                            <td class="py-3 px-5">
                                @if($pengguna->role === 'admin')
                                    <span class="badge-info">Admin</span>
                                @elseif($pengguna->role === 'mitra')
                                    <span class="badge-warning">Mitra</span>
                                @else
                                    <span class="badge-success">Masyarakat</span>
                                @endif
                            </td>
                            <td class="py-3 px-5">
                                @if($pengguna->is_approved)
                                    <span class="badge-success"><i class="ph-fill ph-check-circle text-xs"></i> Aktif</span>
                                @else
                                    <span class="badge-warning"><i class="ph-fill ph-hourglass text-xs"></i> Pending</span>
                                @endif
                            </td>
                            <td class="py-3 px-5 text-sm text-slate-400">{{ $pengguna->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $semuaPengguna->links() }}
            </div>
        </div>
    </div>
</x-dashboard-layout>
