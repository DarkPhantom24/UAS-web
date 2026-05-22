<?php

namespace App\Ai\Agents;

use Illuminate\Support\Facades\Http;
use Stringable;

class MitraAgent
{
    use Promptable;

    protected $promptText = '';

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'Kamu adalah AI Admin EcoBank (platform e-waste / daur ulang sampah elektronik). ' .
               'Tugasmu adalah memverifikasi pendaftaran mitra baru berdasarkan NAMA LAPAK mereka saja. ' .
               'PENTING: Kamu HANYA memverifikasi nama lapak, ABAIKAN nama mitra. ' .
               'Kamu harus memutuskan apakah mitra layak disetujui (approve) atau ditolak (reject).' .
               "\n\n=== KETENTUAN PENOLAKAN (WAJIB DITOLAK) ===" .
               "\nTolak jika NAMA LAPAK mengandung:" .
               "\n1. Kata kasar, vulgar, atau tidak pantas (contoh: bajingan, brengsek, bangsat, anjing, babi, setan, dll)" .
               "\n2. Unsur SARA, diskriminasi, rasisme, atau ujaran kebencian" .
               "\n3. Kata uji coba: 'test', 'testing', 'dummy', 'fake', 'asal', 'coba', 'xxx', 'asdf', 'qwerty', 'abc123'" .
               "\n4. Nama lapak terlalu pendek (kurang dari 3 huruf)" .
               "\n5. Hanya angka atau karakter spesial saja tanpa huruf yang bermakna" .
               "\n6. Kata terkait penipuan: 'scam', 'tipu', 'palsu', 'bohong', 'penipu', 'hoax'" .
               "\n7. Nama random tidak bermakna (karakter acak seperti 'asjdhaksd', 'xxyyzz')" .
               "\n8. Mengandung kata-kata seksual atau pornografi" .
               "\n\n=== KETENTUAN PERSETUJUAN ===" .
               "\n- Nama lapak wajar dan bisa dibaca oleh manusia" .
               "\n- Nama lapak relevan dengan bisnis (daur ulang, elektronik, sampah, jual beli, dsb)" .
               "\n- Tidak melanggar satupun ketentuan penolakan di atas" .
               "\n- NAMA MITRA TIDAK PERLU DIVERIFIKASI, fokus hanya pada nama lapak" .
               "\n\n=== FORMAT RESPONS ===" .
               "\nKamu HARUS merespons HANYA dalam format JSON array murni, TANPA markdown, TANPA backtick, TANPA penjelasan tambahan." .
               "\nContoh: [{\"id\":1,\"keputusan\":\"approve\",\"alasan\":\"Nama lapak valid dan relevan\"},{\"id\":2,\"keputusan\":\"reject\",\"alasan\":\"Nama lapak mengandung kata tidak pantas\"}]";
    }

    /**
     * Create a new instance of the agent.
     */
    public static function make()
    {
        return new static();
    }

    /**
     * Send prompt to the AI provider.
     */
    public function prompt(string $text, string $provider = 'groq')
    {
        $this->promptText = $text;

        if ($provider === 'groq') {
            return $this->callGroq();
        }

        return "Provider not supported.";
    }

    /**
     * Call Groq API (OpenAI-compatible format).
     */
    private function callGroq()
    {
        $apiKey = env('GROQ_API_KEY');

        if (!$apiKey) {
            return "⚠️ GROQ API key tidak dikonfigurasi.";
        }

        $systemPrompt = (string) $this->instructions();

        try {
            $url = "https://api.groq.com/openai/v1/chat/completions";

            $response = Http::timeout(60)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $apiKey,
                ])
                ->post($url, [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $this->promptText],
                    ],
                    'temperature' => 0.2,
                    'max_tokens' => 2048,
                ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['choices'][0]['message']['content'])) {
                    return $data['choices'][0]['message']['content'];
                }

                return "❌ Format respons tidak sesuai.";
            }

            $errorBody = $response->json();
            $errorMsg = $errorBody['error']['message'] ?? 'Unknown error';

            return "❌ API Error: " . $errorMsg;

        } catch (\Exception $e) {
            return "❌ Error: " . $e->getMessage();
        }
    }
}

trait Promptable
{
    /**
     * Get the instructions that the agent should follow.
     * This method should be overridden in the agent class.
     */
    public function instructions(): Stringable|string
    {
        return '';
    }
}
