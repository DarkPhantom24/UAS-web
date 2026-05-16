<x-dashboard-layout title="Pengaturan" section_title="Pengaturan Sistem" role="admin">
    <!-- Pengaturan Poin & Reward -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">💰 Pengaturan Poin & Reward</h3>
        <form action="#" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Poin per Kg E-Waste</label>
                    <div class="relative">
                        <input type="number" name="poin_per_kg" value="100" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <span class="absolute right-3 top-2.5 text-slate-500 text-sm">poin</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Poin yang didapat kontributor per kg e-waste</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nilai Rupiah per Poin</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-slate-500 text-sm">Rp</span>
                        <input type="number" name="rupiah_per_poin" value="75" class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Konversi poin ke rupiah untuk kontributor</p>
                </div>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <p class="text-sm text-blue-800">
                    <strong>Contoh:</strong> Jika kontributor menyerahkan 5 kg e-waste, mereka akan mendapat <strong>500 poin</strong> (5 × 100) senilai <strong>Rp 37.500</strong> (500 × 75)
                </p>
            </div>
            <button type="submit" class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                Simpan Pengaturan Poin
            </button>
        </form>
    </div>

    <!-- Pengaturan Harga Mitra -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">🚚 Pengaturan Harga Mitra</h3>
        <form action="#" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Estimasi Pendapatan Mitra per Kg</label>
                <div class="relative max-w-md">
                    <span class="absolute left-3 top-2.5 text-slate-500 text-sm">Rp</span>
                    <input type="number" name="mitra_pendapatan_per_kg" value="5000" step="100" class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <p class="text-xs text-slate-500 mt-1">Estimasi pendapatan yang ditampilkan ke mitra per kg e-waste</p>
            </div>
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3">
                <p class="text-sm text-amber-800">
                    <strong>Info:</strong> Ini hanya estimasi yang ditampilkan. Pendapatan aktual mitra tergantung harga jual e-waste ke pengepul besar.
                </p>
            </div>
            <button type="submit" class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                Simpan Pengaturan Harga
            </button>
        </form>
    </div>

    <!-- Pengaturan Kategori E-Waste -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">📦 Kategori E-Waste</h3>
        
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <!-- Daftar Kategori -->
        <div class="space-y-2 mb-4">
            @forelse($categories as $category)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <span class="text-slate-700 font-medium">{{ $category->name }}</span>
                    <div class="flex gap-2">
                        <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}')" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Edit
                        </button>
                        <form action="{{ route('admin.category.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-slate-500 text-sm text-center py-4">Belum ada kategori</p>
            @endforelse
        </div>

        <!-- Form Tambah Kategori -->
        <form action="{{ route('admin.category.store') }}" method="POST" class="flex gap-2">
            @csrf
            <input type="text" name="name" placeholder="Nama kategori baru" required class="flex-1 px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            <button type="submit" class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                + Tambah
            </button>
        </form>

        @error('name')
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Modal Edit Kategori -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Edit Kategori</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="text" id="editName" name="name" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent mb-4">
                <div class="flex gap-2">
                    <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editCategory(id, name) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editName').value = name;
            document.getElementById('editForm').action = `/admin/category/${id}`;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>

    <!-- Pengaturan Profil Admin -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">👤 Profil Admin</h3>
        <form action="#" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ Auth::user()->phone }}" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
            <hr class="my-6">
            <h4 class="font-semibold text-slate-800 mb-3">Ubah Password</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password Lama</label>
                    <input type="password" name="current_password" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                    <input type="password" name="new_password" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </div>
            <p class="text-xs text-slate-500">Kosongkan jika tidak ingin mengubah password</p>
            <button type="submit" class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                Simpan Profil
            </button>
        </form>
    </div>
</x-dashboard-layout>
