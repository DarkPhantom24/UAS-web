<x-auth-layout title="Daftar" section_title="Buat Akun Baru" section_description="Pilih tipe akun dan lengkapi data Anda">
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('auth.store') }}" method="POST" class="flex flex-col gap-5" x-data="{ role: '{{ old('role', 'masyarakat') }}' }">
        @csrf

        {{-- Role Selection --}}
        <div class="flex flex-col gap-2">
            <label class="font-semibold text-sm text-slate-700">Tipe Akun</label>
            <div class="grid grid-cols-2 gap-3">
                <label :class="role === 'masyarakat' ? 'border-ewaste-500 bg-ewaste-50 ring-2 ring-ewaste-500/20' : 'border-slate-200 bg-white hover:border-slate-300'"
                       class="relative flex flex-col items-center gap-2 p-4 rounded-xl border cursor-pointer transition-all duration-200">
                    <input type="radio" name="role" value="masyarakat" x-model="role" class="sr-only">
                    <div :class="role === 'masyarakat' ? 'bg-ewaste-500 text-white' : 'bg-slate-100 text-slate-500'"
                         class="w-10 h-10 rounded-lg flex items-center justify-center transition-colors">
                        <i class="ph ph-user text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-center text-slate-700">Masyarakat (Kontributor)</span>
                </label>
                <label :class="role === 'mitra' ? 'border-ewaste-500 bg-ewaste-50 ring-2 ring-ewaste-500/20' : 'border-slate-200 bg-white hover:border-slate-300'"
                       class="relative flex flex-col items-center gap-2 p-4 rounded-xl border cursor-pointer transition-all duration-200">
                    <input type="radio" name="role" value="mitra" x-model="role" class="sr-only">
                    <div :class="role === 'mitra' ? 'bg-ewaste-500 text-white' : 'bg-slate-100 text-slate-500'"
                         class="w-10 h-10 rounded-lg flex items-center justify-center transition-colors">
                        <i class="ph ph-truck text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-center text-slate-700">Mitra Pengepul / Pemilik Lapak</span>
                </label>
            </div>
        </div>

        {{-- Common Fields --}}
        <div class="flex flex-col gap-2">
            <label for="name" class="font-semibold text-sm text-slate-700">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="input-ewaste" placeholder="Masukkan nama lengkap" value="{{ old('name') }}">
        </div>
        <div class="flex flex-col gap-2">
            <label for="reg-email" class="font-semibold text-sm text-slate-700">Email</label>
            <input type="email" id="reg-email" name="email" class="input-ewaste" placeholder="nama@email.com" value="{{ old('email') }}">
        </div>
        <div class="flex flex-col gap-2">
            <label for="phone" class="font-semibold text-sm text-slate-700">No. Telepon</label>
            <input type="text" id="phone" name="phone" class="input-ewaste" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
        </div>

        {{-- Mitra-specific Fields --}}
        <div x-show="role === 'mitra'" x-transition class="flex flex-col gap-5">
            <div class="flex flex-col gap-2">
                <label for="nama_lapak" class="font-semibold text-sm text-slate-700">Jenis Kendaraan / Nama Lapak</label>
                <input type="text" id="nama_lapak" name="nama_lapak" class="input-ewaste" placeholder="cth: Lapak Jaya / Motor Roda Tiga" value="{{ old('nama_lapak') }}">
            </div>
            <div class="flex flex-col gap-2">
                <label for="alamat_lapak" class="font-semibold text-sm text-slate-700">Alamat Lapak / Wilayah Operasi</label>
                <input type="text" id="alamat_lapak" name="alamat_lapak" class="input-ewaste" placeholder="cth: Jl. Raya Bogor No. 10" value="{{ old('alamat_lapak') }}">
            </div>
        </div>

        {{-- Password Fields --}}
        <div class="flex flex-col gap-2">
            <label for="reg-password" class="font-semibold text-sm text-slate-700">Kata Sandi</label>
            <input type="password" id="reg-password" name="password" class="input-ewaste" placeholder="Minimal 6 karakter">
        </div>
        <div class="flex flex-col gap-2">
            <label for="confirm_password" class="font-semibold text-sm text-slate-700">Konfirmasi Kata Sandi</label>
            <input type="password" id="confirm_password" name="confirm_password" class="input-ewaste" placeholder="Ulangi kata sandi">
        </div>

        <button type="submit" class="btn-primary w-full mt-2">
            <i class="ph ph-user-plus text-lg"></i>
            Daftar
        </button>

        <p class="text-slate-500 text-sm text-center">
            Sudah punya akun?
            <a href="{{ route('auth.login') }}" class="text-ewaste-600 font-semibold hover:underline">Masuk</a>
        </p>
    </form>
</x-auth-layout>
