<?php

namespace App\Services;

/**
 * ═══════════════════════════════════════════════════════════════════
 *  SISTEM CERDAS: Verifikasi Mitra Otomatis (Expert System)
 * ═══════════════════════════════════════════════════════════════════
 *
 *  Sistem Pakar berbasis Rule-Based Scoring untuk memverifikasi
 *  kelayakan pendaftaran mitra secara otomatis.
 *
 *  Cara Kerja:
 *  1. Setiap mitra dimulai dengan skor 100
 *  2. Sistem mengevaluasi nama lapak melalui beberapa aturan
 *  3. Pelanggaran aturan mengurangi skor
 *  4. Jika skor >= threshold (60) → APPROVE, jika < → REJECT
 *
 *  Aturan yang dipakai:
 *  - Blacklist kata terlarang (kasar, SARA, penipuan)
 *  - Validasi panjang minimum nama
 *  - Deteksi karakter random/spam
 *  - Deteksi nama hanya angka/simbol
 *  - Deteksi kata uji coba (test, dummy, dsb)
 *  - Bonus: nama mengandung kata relevan bisnis
 * ═══════════════════════════════════════════════════════════════════
 */
class MitraVerificationService
{
    /**
     * Skor awal untuk setiap mitra
     */
    const INITIAL_SCORE = 100;

    /**
     * Ambang batas minimum untuk disetujui
     */
    const APPROVAL_THRESHOLD = 60;

    /**
     * Daftar kata terlarang (kasar, vulgar, tidak pantas)
     */
    protected array $blacklistWords = [
        // Kata kasar / vulgar
        'bajingan', 'brengsek', 'bangsat', 'anjing', 'babi', 'setan',
        'iblis', 'kampret', 'goblok', 'tolol', 'idiot', 'bodoh',
        'bego', 'tai', 'kontol', 'memek', 'ngentot', 'jancuk',
        'asu', 'sundal', 'lonte', 'pelacur', 'keparat',

        // SARA & diskriminasi
        'kafir', 'rasis', 'nazi',

        // Penipuan
        'scam', 'tipu', 'palsu', 'bohong', 'penipu', 'hoax', 'menipu',
        'penipuan', 'fraud',

        // Pornografi
        'porno', 'bokep', 'seks', 'porn', 'xxx',
    ];

    /**
     * Daftar kata uji coba / testing
     */
    protected array $testWords = [
        'test', 'testing', 'dummy', 'fake', 'asal', 'coba',
        'asdf', 'qwerty', 'abc123', 'abc', 'xyz', 'lorem',
        'ipsum', 'contoh', 'sampel', 'percobaan', 'tes',
    ];

    /**
     * Kata-kata relevan dengan bisnis e-waste / daur ulang (bonus)
     */
    protected array $relevantWords = [
        'elektronik', 'recycle', 'daur', 'ulang', 'sampah', 'limbah',
        'eco', 'green', 'hijau', 'bersih', 'jaya', 'makmur', 'sejahtera',
        'mandiri', 'maju', 'abadi', 'sentosa', 'berkah', 'barokah',
        'lapak', 'toko', 'usaha', 'karya', 'teknik', 'solusi',
        'digital', 'komputer', 'gadget', 'service', 'servis', 'PT', 'CV', 
        'Toko', 'Jaya', 'Mandiri', 'Makmur', 'Sejahtera', 'Berkah', 'Barokah', 
        'Lapak', 'Toko', 'Usaha', 'Karya', 'Teknik', 'Solusi', 'Digital', 'Komputer', 
        'Gadget', 'Service', 'Servis'
    ];

    /**
     * Verifikasi batch — proses semua mitra sekaligus
     *
     * @param \Illuminate\Support\Collection $mitraList
     * @return array Hasil verifikasi
     */
    public function verifyBatch($mitraList): array
    {
        $results = [];
        $approved = 0;
        $rejected = 0;

        foreach ($mitraList as $mitra) {
            $result = $this->verify($mitra);

            if ($result['keputusan'] === 'approve') {
                $mitra->update(['is_approved' => true]);
                $approved++;
            } else {
                $mitra->delete();
                $rejected++;
            }

            $results[] = [
                'id' => $mitra->id,
                'nama' => $mitra->name,
                'nama_lapak' => $mitra->nama_lapak ?? '-',
                'keputusan' => $result['keputusan'],
                'alasan' => $result['alasan'],
                'skor' => $result['skor'],
                'detail_rules' => $result['detail_rules'],
            ];
        }

        return [
            'results' => $results,
            'approved' => $approved,
            'rejected' => $rejected,
        ];
    }

    /**
     * Verifikasi satu mitra menggunakan Sistem Pakar
     *
     * @param \App\Models\User $mitra
     * @return array
     */
    public function verify($mitra): array
    {
        $namaLapak = strtolower(trim($mitra->nama_lapak ?? ''));
        $score = self::INITIAL_SCORE;
        $violations = [];
        $bonuses = [];

        // ═══ RULE 1: Nama lapak kosong atau tidak diisi ═══
        if (empty($namaLapak) || $namaLapak === '-') {
            $score -= 100;
            $violations[] = 'Nama lapak tidak diisi';
        }

        if ($score > 0 && !empty($namaLapak) && $namaLapak !== '-') {

            // ═══ RULE 2: Blacklist — Kata terlarang (kasar, SARA, penipuan) ═══
            $foundBlacklist = $this->findMatchingWords($namaLapak, $this->blacklistWords);
            if (!empty($foundBlacklist)) {
                $score -= 100; // Langsung gagal
                $violations[] = 'Mengandung kata terlarang: ' . implode(', ', $foundBlacklist);
            }

            // ═══ RULE 3: Kata uji coba / testing ═══
            $foundTestWords = $this->findMatchingWords($namaLapak, $this->testWords);
            if (!empty($foundTestWords)) {
                $score -= 60;
                $violations[] = 'Terdeteksi sebagai uji coba: ' . implode(', ', $foundTestWords);
            }

            // ═══ RULE 4: Nama terlalu pendek (< 3 karakter) ═══
            if (mb_strlen($namaLapak) < 3) {
                $score -= 60;
                $violations[] = 'Nama lapak terlalu pendek (kurang dari 3 karakter)';
            }

            // ═══ RULE 5: Hanya angka atau simbol tanpa huruf ═══
            if (!preg_match('/[a-zA-Z]/', $namaLapak)) {
                $score -= 50;
                $violations[] = 'Nama lapak hanya berisi angka/simbol tanpa huruf';
            }

            // ═══ RULE 6: Karakter random / tidak bermakna ═══
            if ($this->isRandomString($namaLapak)) {
                $score -= 45;
                $violations[] = 'Nama lapak terdeteksi sebagai karakter acak/tidak bermakna';
            }

            // ═══ RULE 7: Mengandung angka berlebihan (>50% angka) ═══
            if ($this->hasTooManyNumbers($namaLapak)) {
                $score -= 25;
                $violations[] = 'Nama lapak mengandung terlalu banyak angka';
            }

            // ═══ RULE 8: Pengulangan karakter berlebihan ═══
            if ($this->hasExcessiveRepetition($namaLapak)) {
                $score -= 30;
                $violations[] = 'Nama lapak mengandung pengulangan karakter berlebihan';
            }

            // ═══ BONUS: Nama mengandung kata relevan bisnis ═══
            $foundRelevant = $this->findMatchingWords($namaLapak, $this->relevantWords);
            if (!empty($foundRelevant)) {
                $score += 10;
                $bonuses[] = 'Mengandung kata relevan: ' . implode(', ', $foundRelevant);
            }
        }

        // Clamp score ke 0-110
        $score = max(0, min(110, $score));

        // Keputusan akhir
        $keputusan = $score >= self::APPROVAL_THRESHOLD ? 'approve' : 'reject';

        // Buat alasan yang mudah dibaca
        if ($keputusan === 'approve') {
            $alasan = empty($violations)
                ? 'Nama lapak valid dan memenuhi semua kriteria'
                : 'Nama lapak memenuhi kriteria minimum meskipun ada catatan kecil';
            if (!empty($bonuses)) {
                $alasan .= ' (' . implode('; ', $bonuses) . ')';
            }
        } else {
            $alasan = implode('; ', $violations);
        }

        return [
            'keputusan' => $keputusan,
            'alasan' => $alasan,
            'skor' => $score,
            'detail_rules' => [
                'violations' => $violations,
                'bonuses' => $bonuses,
            ],
        ];
    }

    /**
     * Cari kata yang cocok dari daftar dalam sebuah string
     */
    protected function findMatchingWords(string $text, array $wordList): array
    {
        $found = [];
        foreach ($wordList as $word) {
            if (mb_stripos($text, $word) !== false) {
                $found[] = $word;
            }
        }
        return $found;
    }

    /**
     * Deteksi apakah string terlihat random/acak
     *
     * Logika: Hitung rasio konsonan berturut-turut.
     * Bahasa Indonesia/Inggris jarang punya 4+ konsonan berturut-turut.
     */
    protected function isRandomString(string $text): bool
    {
        // Hapus spasi & angka untuk analisis
        $clean = preg_replace('/[\s\d\W]+/', '', $text);

        if (mb_strlen($clean) < 4) {
            return false;
        }

        $vowels = 'aiueo';
        $consonantStreak = 0;
        $maxStreak = 0;

        for ($i = 0; $i < mb_strlen($clean); $i++) {
            $char = mb_strtolower(mb_substr($clean, $i, 1));
            if (mb_strpos($vowels, $char) === false) {
                $consonantStreak++;
                $maxStreak = max($maxStreak, $consonantStreak);
            } else {
                $consonantStreak = 0;
            }
        }

        // 4+ konsonan berturut-turut → kemungkinan random
        if ($maxStreak >= 4) {
            return true;
        }

        // Cek keunikan karakter — jika terlalu banyak karakter unik
        // relatif terhadap panjang, mungkin random
        $uniqueRatio = count(array_unique(str_split($clean))) / mb_strlen($clean);
        if (mb_strlen($clean) >= 6 && $uniqueRatio > 0.9) {
            return true;
        }

        return false;
    }

    /**
     * Cek apakah lebih dari 50% karakter adalah angka
     */
    protected function hasTooManyNumbers(string $text): bool
    {
        $clean = str_replace(' ', '', $text);
        if (empty($clean)) return false;

        $digitCount = preg_match_all('/\d/', $clean);
        return ($digitCount / mb_strlen($clean)) > 0.5;
    }

    /**
     * Cek pengulangan karakter berlebihan (misal: aaaaaaa, bbbbb)
     */
    protected function hasExcessiveRepetition(string $text): bool
    {
        // Cek jika ada 4+ karakter yang sama berturut-turut
        return (bool) preg_match('/(.)\1{3,}/', $text);
    }
}
