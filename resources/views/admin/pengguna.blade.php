<x-dashboard-layout title="Kelola Pengguna" section_title="Kelola Pengguna" role="admin">
    <div class="space-y-6">

        @if(session('success'))
        <div class="bg-ewaste-50 border border-ewaste-300 text-ewaste-700 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>
        @endif

        {{-- Mitra Pending Approval --}}
        @if($mitraPending->count() > 0)
        <div class="bg-amber-50 border border-amber-200 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-amber-200">
                <div class="flex items-center gap-2">
                    <i class="ph ph-warning-circle text-amber-600 text-lg"></i>
                    <h3 class="font-bold text-amber-800">Mitra Menunggu Persetujuan ({{ $mitraPending->count() }})</h3>
                </div>
                {{-- AI Review Button --}}
                <button id="btn-ai-review" onclick="runAiReview()"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105"
                    style="background: linear-gradient(135deg, #8B5CF6, #6D28D9);">
                    <i class="ph ph-robot text-sm"></i>
                    <span id="btn-ai-text">AI Auto-Review</span>
                    <svg id="btn-ai-spinner" class="hidden animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </button>
            </div>

            {{-- AI Results Panel (hidden by default) --}}
            <div id="ai-results-panel" class="hidden border-b border-amber-200">
                <div class="px-5 py-4 bg-gradient-to-r from-violet-50 to-purple-50">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="ph ph-robot text-violet-600 text-lg"></i>
                        <h4 class="font-bold text-violet-800 text-sm">Hasil AI Review</h4>
                        <span id="ai-summary" class="text-xs text-violet-600 ml-auto"></span>
                    </div>
                    <div id="ai-results-list" class="space-y-2 max-h-64 overflow-y-auto"></div>
                </div>
            </div>

            {{-- AI Error Panel (hidden by default) --}}
            <div id="ai-error-panel" class="hidden border-b border-amber-200">
                <div class="px-5 py-4 bg-red-50">
                    <div class="flex items-center gap-2">
                        <i class="ph ph-warning text-red-500 text-lg"></i>
                        <p id="ai-error-msg" class="text-sm text-red-700"></p>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-amber-100">
                @foreach($mitraPending as $mitra)
                <div class="flex items-center p-5 gap-4" id="mitra-row-{{ $mitra->id }}">
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

    {{-- AI Review JavaScript --}}
    <script>
        function runAiReview() {
            const btn = document.getElementById('btn-ai-review');
            const btnText = document.getElementById('btn-ai-text');
            const spinner = document.getElementById('btn-ai-spinner');
            const resultsPanel = document.getElementById('ai-results-panel');
            const resultsList = document.getElementById('ai-results-list');
            const errorPanel = document.getElementById('ai-error-panel');
            const errorMsg = document.getElementById('ai-error-msg');
            const summary = document.getElementById('ai-summary');

            // Confirm action
            if (!confirm('Jalankan AI Auto-Review untuk semua mitra pending?\n\nAI akan menganalisis nama mitra & lapak, lalu otomatis menyetujui atau menolak.')) {
                return;
            }

            // Loading state
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.style.cursor = 'wait';
            btnText.textContent = 'AI sedang menganalisis...';
            spinner.classList.remove('hidden');
            resultsPanel.classList.add('hidden');
            errorPanel.classList.add('hidden');

            // AJAX call
            fetch('{{ route("admin.pengguna.ai-review") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                // Reset button
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
                btnText.textContent = 'AI Auto-Review';
                spinner.classList.add('hidden');

                if (data.error) {
                    // Show error
                    errorPanel.classList.remove('hidden');
                    errorMsg.textContent = data.message;
                    return;
                }

                // Show results
                resultsPanel.classList.remove('hidden');
                summary.textContent = `✅ ${data.approved} disetujui · ❌ ${data.rejected} ditolak`;

                resultsList.innerHTML = '';
                data.results.forEach(result => {
                    const isApproved = result.keputusan === 'approve';
                    const div = document.createElement('div');
                    div.className = `flex items-center gap-3 p-3 rounded-xl text-sm ${isApproved ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'}`;
                    div.innerHTML = `
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 text-white text-xs font-bold ${isApproved ? 'bg-green-500' : 'bg-red-500'}">
                            <i class="ph ph-${isApproved ? 'check' : 'x'} text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold ${isApproved ? 'text-green-800' : 'text-red-800'} truncate">${result.nama} <span class="font-normal text-xs opacity-70">· ${result.nama_lapak}</span></p>
                            <p class="text-xs ${isApproved ? 'text-green-600' : 'text-red-600'} mt-0.5">${result.alasan}</p>
                        </div>
                        <span class="shrink-0 px-2 py-1 rounded-lg text-xs font-bold ${isApproved ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'}">
                            ${isApproved ? 'APPROVED' : 'REJECTED'}
                        </span>
                    `;
                    resultsList.appendChild(div);

                    // Fade out the mitra row from the pending list
                    const row = document.getElementById(`mitra-row-${result.id}`);
                    if (row) {
                        row.style.transition = 'opacity 0.5s, transform 0.5s';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(20px)';
                        setTimeout(() => row.remove(), 600);
                    }
                });

            })
            .catch(error => {
                // Reset button
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
                btnText.textContent = 'AI Auto-Review';
                spinner.classList.add('hidden');

                // Show error
                errorPanel.classList.remove('hidden');
                errorMsg.textContent = 'Gagal menghubungi server. Periksa koneksi internet.';
                console.error('AI Review Error:', error);
            });
        }
    </script>

</x-dashboard-layout>
