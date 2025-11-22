<?php

namespace App\Jobs;

use App\Models\Guest;
use App\Models\Voucher;
use App\Mail\VoucherNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GenerateVoucherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $guest;

    /**
     * Create a new job instance.
     */
    public function __construct(Guest $guest)
    {
        $this->guest = $guest;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // 1. Cek apakah tamu sudah punya voucher
            if ($this->guest->voucher) {
                Log::info("Tamu {$this->guest->email} sudah memiliki voucher.");
                return;
            }

            // 2. Buat kode voucher unik
            $code = 'WEDD-VOUCHER-' . Str::upper(Str::random(10));

            // 3. Simpan voucher ke database
            $voucher = Voucher::create([
                'guest_id' => $this->guest->id,
                'code' => $code,
                'status' => 'unused',
            ]);

            // 4. Generate QR Code
            $qrcode = new \chillerlan\QRCode\QRCode();
            $qrCodeBase64 = $qrcode->render($voucher->code);

            // 5. Generate voucher link
            $voucherLink = route('voucher.show', ['code' => $voucher->code]);

            // 6. Kirim email dengan QR code dan link
            Mail::to($this->guest->email)->send(new VoucherNotification(
                $this->guest,
                $voucher->code,
                $voucherLink,
                $qrCodeBase64
            ));

            // 6. Kirim WA menggunakan WAHA dengan link
            $this->sendWhatsApp($this->guest, $voucherLink, $voucher->code);

            Log::info("Voucher {$code} berhasil dibuat untuk {$this->guest->email}.");
        } catch (\Exception $e) {
            Log::error("Gagal membuat voucher untuk {$this->guest->email}: " . $e->getMessage());
        }
    }

    /**
     * Helper function untuk mengirim WhatsApp via WAHA.
     */
    protected function sendWhatsApp(Guest $guest, string $voucherLink, string $voucherCode)
    {
        // Ambil konfigurasi dari config/services.php
        $baseUrl = config('services.waha.base_url');
        $session = config('services.waha.session');
        $apiKey = config('services.waha.api_key');

        if (!$baseUrl) {
            Log::error('WAHA Error: WAHA_BASE_URL tidak diatur.');
            return;
        }

        // Nomor WA harus dalam format 62... (tanpa +)
        $phone = $guest->phone;
        if (str_starts_with($phone, '+')) {
            $phone = substr($phone, 1);
        }

        // Pesan teks dengan link
        $message = "🎉 *Halo {$guest->name}!*\n\n";
        $message .= "Terima kasih telah melakukan RSVP untuk pernikahan kami! 💒\n\n";
        $message .= "Sebagai ucapan terima kasih, kami berikan voucher diskon *10%* untuk merchandise pernikahan.\n\n";
        $message .= "📱 *Kode Voucher:* `{$voucherCode}`\n\n";
        $message .= "Klik link di bawah untuk melihat QR Code voucher Anda:\n";
        $message .= "👉 {$voucherLink}\n\n";
        $message .= "Tunjukkan QR Code kepada tim merchandise untuk mendapatkan diskon.\n\n";
        $message .= "Sampai jumpa di hari H! 🎊";

        // Endpoint WAHA untuk mengirim pesan teks
        $endpoint = "{$baseUrl}/api/sessions/{$session}/messages";

        try {
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            // Tambahkan API Key jika ada di konfigurasi
            if (!empty($apiKey)) {
                $headers['X-Api-Key'] = $apiKey;
            }

            $response = Http::withHeaders($headers)
                ->post($endpoint, [
                    'chatId' => "{$phone}@c.us", // Format @c.us untuk nomor pribadi
                    'text' => $message,
                ]);

            if ($response->successful()) {
                Log::info("Notifikasi WA (WAHA) terkirim ke {$phone}");
            } else {
                Log::error("Gagal kirim WA (WAHA) ke {$phone}: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("Exception saat kirim WA (WAHA) ke {$phone}: " . $e->getMessage());
        }
    }
}
