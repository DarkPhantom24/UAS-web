<?php

namespace App\Http\Controllers;

use App\Ai\Agents\MitraAgent;
use App\Models\EwasteRequest;
use App\Models\User;
use App\Support\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    // ═══════════════════════════════════════════════════
    //  USER (Masyarakat) CONTROLLERS
    // ═══════════════════════════════════════════════════

    public function userDashboard()
    {
        $user = Auth::user();
        $requests = EwasteRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $totalPoin = EwasteRequest::where('user_id', $user->id)
            ->where('status', 'selesai')
            ->sum('berat') * 100; // 100 poin per kg

        $saldo = $totalPoin * 75; // Rp 75 per poin

        return view('user.dashboard', compact('requests', 'totalPoin', 'saldo'));
    }

    public function userRequest()
    {
        $requests = EwasteRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = \App\Models\Category::orderBy('name')->get();

        return view('user.request', compact('requests', 'categories'));
    }

    public function userStoreRequest(Request $request)
    {
        Gate::authorize('store-request');

        $validated = $request->validate([
            'kategori' => 'required|string',
            'berat' => 'required|numeric|min:0.1',
            'alamat' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        EwasteRequest::create([
            'user_id' => Auth::id(),
            'kategori' => $validated['kategori'],
            'berat' => $validated['berat'],
            'alamat' => $validated['alamat'],
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'menunggu',
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Request berhasil dibuat!');
    }

    public function userRiwayat()
    {
        $requests = EwasteRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.riwayat', compact('requests'));
    }

    public function userPoin()
    {
        $user = Auth::user();
        $totalPoin = EwasteRequest::where('user_id', $user->id)
            ->where('status', 'selesai')
            ->sum('berat') * 100;

        $saldo = $totalPoin * 75;

        return view('user.poin', compact('totalPoin', 'saldo'));
    }

    // ═══════════════════════════════════════════════════
    //  MITRA (Pengepul / Bos Lapak) CONTROLLERS
    // ═══════════════════════════════════════════════════

    public function mitraDashboard()
    {
        $mitra = Auth::user();

        // Tugas tersedia (menunggu, belum ada mitra)
        $tugasTersedia = EwasteRequest::whereNull('mitra_id')
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->get();

        // Order aktif milik mitra ini
        $orderAktif = EwasteRequest::where('mitra_id', $mitra->id)
            ->whereIn('status', ['diambil', 'diproses'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik mitra
        $totalSelesai = EwasteRequest::where('mitra_id', $mitra->id)
            ->where('status', 'selesai')->count();
        $totalBerat = EwasteRequest::where('mitra_id', $mitra->id)
            ->where('status', 'selesai')->sum('berat');

        return view('mitra.dashboard', compact('tugasTersedia', 'orderAktif', 'totalSelesai', 'totalBerat'));
    }

    public function mitraTugas()
    {
        $tugasTersedia = EwasteRequest::whereNull('mitra_id')
            ->where('status', 'menunggu')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mitra.tugas', compact('tugasTersedia'));
    }

    public function mitraAmbilOrder(EwasteRequest $ewasteRequest)
    {
        Gate::authorize('ambil-order');

        $ewasteRequest->update([
            'mitra_id' => Auth::id(),
            'status' => 'diambil',
        ]);

        return redirect()->route('mitra.dashboard')->with('success', 'Order berhasil diambil!');
    }

    public function mitraUpdateStatus(Request $request, EwasteRequest $ewasteRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:diproses,selesai,dibatalkan',
        ]);

        $ewasteRequest->update(['status' => $validated['status']]);

        return redirect()->route('mitra.dashboard')->with('success', 'Status berhasil diperbarui!');
    }

    public function mitraRiwayat()
    {
        $riwayat = EwasteRequest::where('mitra_id', Auth::id())
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('mitra.riwayat', compact('riwayat'));
    }

    public function mitraScan()
    {
        return view('mitra.scan');
    }

    // ═══════════════════════════════════════════════════
    //  ADMIN (Kelompok 4) CONTROLLERS
    // ═══════════════════════════════════════════════════

    public function adminDashboard()
    {
        $totalSampah = EwasteRequest::where('status', 'selesai')->sum('berat');
        $mitraAktif = User::where('role', 'mitra')->where('is_approved', true)->count();
        $totalPengguna = User::count();
        $transaksiAktif = EwasteRequest::whereIn('status', ['menunggu', 'diambil', 'diproses'])->count();

        // Data transaksi terbaru
        $transaksiTerbaru = EwasteRequest::with(['user', 'mitra'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Data chart: jumlah berat selesai per bulan (12 bulan terakhir)
        $chartData = [];
        $chartLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabels[] = $date->translatedFormat('M');
            $chartData[] = (float) EwasteRequest::where('status', 'selesai')
                ->whereMonth('updated_at', $date->month)
                ->whereYear('updated_at', $date->year)
                ->sum('berat');
        }

        // Data doughnut: per kategori
        $kategoriData = EwasteRequest::where('status', 'selesai')
            ->selectRaw('kategori, SUM(berat) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        return view('admin.dashboard', compact(
            'totalSampah', 'mitraAktif', 'totalPengguna', 'transaksiAktif',
            'transaksiTerbaru', 'chartLabels', 'chartData', 'kategoriData'
        ));
    }

    public function adminTransaksi()
    {
        $transaksi = EwasteRequest::with(['user', 'mitra'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.transaksi', compact('transaksi'));
    }

    public function adminPengguna()
    {
        $mitraPending = User::where('role', 'mitra')
            ->where('is_approved', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $semuaPengguna = User::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.pengguna', compact('mitraPending', 'semuaPengguna'));
    }

    public function adminApproveMitra(User $user)
    {
        Gate::authorize('edit-pengguna');

        $user->update(['is_approved' => true]);

        return redirect()->route('admin.pengguna')->with('success', "Mitra {$user->name} berhasil disetujui!");
    }

    public function adminRejectMitra(User $user)
    {
        Gate::authorize('destroy-pengguna');

        $user->delete();

        return redirect()->route('admin.pengguna')->with('success', 'Mitra berhasil ditolak dan dihapus.');
    }

    // ═══════════════════════════════════════════════════
    //  AI REVIEW — Batch approve/reject mitra via AI
    // ═══════════════════════════════════════════════════

    public function adminAiReviewMitra()
    {
        try {
            $mitraPending = User::where('role', 'mitra')
                ->where('is_approved', false)
                ->get();

            if ($mitraPending->isEmpty()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Tidak ada mitra yang menunggu persetujuan.',
                ], 404);
            }

            // Build prompt with pending mitra data
            $prompt = "Berikut adalah daftar mitra yang mendaftar dan perlu diverifikasi:\n\n";

            foreach ($mitraPending as $mitra) {
                $prompt .= "- ID: {$mitra->id}\n";
                $prompt .= "  Nama Mitra: {$mitra->name}\n";
                $prompt .= "  Email: {$mitra->email}\n";
                $prompt .= "  Nama Lapak: " . ($mitra->nama_lapak ?? 'Tidak diisi') . "\n";
                $prompt .= "  Alamat Lapak: " . ($mitra->alamat_lapak ?? 'Tidak diisi') . "\n\n";
            }

            $prompt .= "Analisis setiap mitra di atas dan berikan keputusan approve/reject dalam format JSON array.";

            \Log::info('AI Mitra Review Request', [
                'total_pending' => $mitraPending->count(),
            ]);

            // Call AI Agent
            $aiResponse = MitraAgent::make()->prompt($prompt, provider: Lab::Groq);

            \Log::info('AI Mitra Review Response', ['raw' => $aiResponse]);

            // Parse JSON response from AI
            // Clean response: remove markdown backticks if any
            $cleanResponse = $aiResponse;
            $cleanResponse = preg_replace('/```json\s*/', '', $cleanResponse);
            $cleanResponse = preg_replace('/```\s*/', '', $cleanResponse);
            $cleanResponse = trim($cleanResponse);

            $decisions = json_decode($cleanResponse, true);

            if (!is_array($decisions)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Gagal memproses respons AI. Format tidak valid.',
                    'raw_response' => config('app.debug') ? $aiResponse : null,
                ], 500);
            }

            // Execute decisions
            $results = [];
            $approved = 0;
            $rejected = 0;

            foreach ($decisions as $decision) {
                $mitraId = $decision['id'] ?? null;
                $keputusan = strtolower($decision['keputusan'] ?? '');
                $alasan = $decision['alasan'] ?? 'Tidak ada alasan.';

                $mitra = $mitraPending->firstWhere('id', $mitraId);

                if (!$mitra) {
                    continue;
                }

                if ($keputusan === 'approve') {
                    $mitra->update(['is_approved' => true]);
                    $approved++;
                } elseif ($keputusan === 'reject') {
                    $mitra->delete();
                    $rejected++;
                }

                $results[] = [
                    'id' => $mitraId,
                    'nama' => $mitra->name,
                    'nama_lapak' => $mitra->nama_lapak ?? '-',
                    'keputusan' => $keputusan,
                    'alasan' => $alasan,
                ];
            }

            return response()->json([
                'success' => true,
                'message' => "AI Review selesai: {$approved} disetujui, {$rejected} ditolak.",
                'approved' => $approved,
                'rejected' => $rejected,
                'results' => $results,
            ]);

        } catch (\Exception $e) {
            \Log::error('AI Mitra Review Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan saat memproses AI Review.',
                'details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function adminLaporan()
    {
        Gate::authorize('view-laporan');

        $laporan = EwasteRequest::with(['user', 'mitra'])
            ->where('status', 'selesai')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('admin.laporan', compact('laporan'));
    }

    public function adminPengaturan()
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('admin.pengaturan', compact('categories'));
    }
}
