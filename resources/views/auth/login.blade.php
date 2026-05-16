<x-auth-layout title="Masuk" section_title="Selamat Datang" section_description="Masuk dengan akun Anda untuk melanjutkan">
    @if (session('success'))
        <div class="bg-ewaste-50 border border-ewaste-300 text-ewaste-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('auth.authenticate') }}" method="POST" class="flex flex-col gap-5">
        @csrf
        @error('email')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror

        <div class="flex flex-col gap-2">
            <label for="email" class="font-semibold text-sm text-slate-700">Email</label>
            <input type="email" id="email" name="email" class="input-ewaste"
                placeholder="nama@email.com" value="{{ old('email') }}">
        </div>
        <div class="flex flex-col gap-2">
            <label for="password" class="font-semibold text-sm text-slate-700">Kata Sandi</label>
            <input type="password" id="password" name="password" class="input-ewaste"
                placeholder="Masukkan kata sandi">
        </div>

        <button type="submit" class="btn-primary w-full mt-2">
            <i class="ph ph-sign-in text-lg"></i>
            Masuk
        </button>

        <p class="text-slate-500 text-sm text-center">
            Belum punya akun?
            <a href="{{ route('auth.register') }}" class="text-ewaste-600 font-semibold hover:underline">Daftar Sekarang</a>
        </p>
    </form>
</x-auth-layout>
