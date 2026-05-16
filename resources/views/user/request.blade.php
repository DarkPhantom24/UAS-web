<x-dashboard-layout title="Request Saya" section_title="Request Saya" role="user">
    <!-- Form Buat Request Baru -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Buat Request Baru</h3>
        <form action="{{ route('user.request.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kategori E-Waste</label>
                    <select name="kategori" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Estimasi Berat (kg)</label>
                    <input type="number" name="berat" step="0.1" min="0.1" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Contoh: 2.5">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Penjemputan</label>
                <textarea name="alamat" rows="2" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Masukkan alamat lengkap"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Catatan (Opsional)</label>
                <textarea name="catatan" rows="2" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Deskripsi barang atau catatan tambahan"></textarea>
            </div>
            <button type="submit" class="w-full md:w-auto px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                Buat Request
            </button>
        </form>
    </div>

    <!-- Daftar Request -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Daftar Request</h3>
        
        @if($requests->isEmpty())
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-slate-500">Belum ada request</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($requests as $req)
                    <div class="border border-slate-200 rounded-lg p-4 hover:border-emerald-300 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-semibold text-slate-800">{{ $req->kategori }}</h4>
                                <p class="text-sm text-slate-500">{{ $req->berat }} kg</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($req->status === 'menunggu') bg-yellow-100 text-yellow-700
                                @elseif($req->status === 'diambil') bg-blue-100 text-blue-700
                                @elseif($req->status === 'diproses') bg-purple-100 text-purple-700
                                @elseif($req->status === 'selesai') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700
                                @endif">
                                {{ ucfirst($req->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mb-2">📍 {{ $req->alamat }}</p>
                        @if($req->catatan)
                            <p class="text-sm text-slate-500 italic">{{ $req->catatan }}</p>
                        @endif
                        @if($req->mitra)
                            <p class="text-sm text-emerald-600 mt-2">✓ Ditangani oleh: {{ $req->mitra->name }}</p>
                        @endif
                        <p class="text-xs text-slate-400 mt-2">{{ $req->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-dashboard-layout>
