<x-dashboard-layout title="Daftar Tugas" section_title="Daftar Tugas" role="mitra">
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Tugas Tersedia</h3>
        
        @if($tugasTersedia->isEmpty())
            <div class="text-center py-12">
                <svg class="w-20 h-20 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <p class="text-slate-500 text-lg">Tidak ada tugas tersedia saat ini</p>
                <p class="text-slate-400 text-sm mt-2">Tugas baru akan muncul ketika ada kontributor yang membuat request</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($tugasTersedia as $tugas)
                    <div class="border border-slate-200 rounded-lg p-5 hover:border-emerald-300 hover:shadow-md transition-all">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h4 class="font-bold text-slate-800 text-lg">{{ $tugas->kategori }}</h4>
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Menunggu</span>
                                </div>
                                <div class="flex items-center gap-4 text-sm text-slate-600 mb-2">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ $tugas->user->name }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                        </svg>
                                        <strong>{{ $tugas->berat }} kg</strong>
                                    </span>
                                    <span class="flex items-center gap-1 text-emerald-600 font-semibold">
                                        💰 Est. {{ number_format($tugas->berat * 5000, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-400 mb-2">{{ $tugas->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-lg p-3 mb-3">
                            <p class="text-sm text-slate-600 mb-1">
                                <strong class="text-slate-700">📍 Alamat:</strong>
                            </p>
                            <p class="text-sm text-slate-700">{{ $tugas->alamat }}</p>
                        </div>

                        @if($tugas->catatan)
                            <div class="bg-blue-50 rounded-lg p-3 mb-3">
                                <p class="text-sm text-slate-600 mb-1">
                                    <strong class="text-slate-700">📝 Catatan:</strong>
                                </p>
                                <p class="text-sm text-slate-700">{{ $tugas->catatan }}</p>
                            </div>
                        @endif

                        <div class="flex items-center gap-2 pt-3 border-t border-slate-200">
                            <form action="{{ route('mitra.ambil-order', $tugas) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors font-medium">
                                    ✓ Ambil Tugas Ini
                                </button>
                            </form>
                            @if($tugas->user->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tugas->user->phone) }}" target="_blank" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-dashboard-layout>
