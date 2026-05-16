<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'role' => 'required|in:masyarakat,mitra',
            'nama_lapak' => 'nullable|string',
            'alamat_lapak' => 'nullable|string',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'nama_lapak' => $validated['nama_lapak'] ?? null,
            'alamat_lapak' => $validated['alamat_lapak'] ?? null,
            // Mitra harus menunggu approval admin, masyarakat langsung approved
            'is_approved' => $validated['role'] === 'masyarakat',
            'password' => Hash::make($validated['password']),
        ]);

        $message = $validated['role'] === 'mitra'
            ? 'Pendaftaran berhasil! Akun Mitra Anda menunggu persetujuan admin.'
            : 'Pendaftaran berhasil! Silakan masuk.';

        return redirect()->route('auth.login')->with('success', $message);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cek apakah akun mitra sudah di-approve admin
            if ($user->role === 'mitra' && !$user->is_approved) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Mitra Anda belum disetujui oleh admin. Silakan tunggu.',
                ])->onlyInput('email');
            }

            // Role-based redirect
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'mitra' => redirect()->route('mitra.dashboard'),
                default => redirect()->route('user.dashboard'),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak sesuai.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
