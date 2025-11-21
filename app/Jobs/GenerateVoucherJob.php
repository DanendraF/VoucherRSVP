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
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateVoucherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $guest;

    public function __construct(Guest $guest)
    {
        $this->guest = $guest;
    }

    public function handle(): void
    {
        try {
            // Jika sudah punya voucher, stop
            if ($this->guest->voucher) {
                Log::info("Tamu {$this->guest->email} sudah punya voucher.");
                return;
            }

            // Generate kode
            $code = 'WEDD-VOUCHER-' . Str::upper(Str::random(10));

            // Simpan voucher
            $voucher = Voucher::create([
                'guest_id' => $this->guest->id,
                'code'     => $code,
                'status'   => 'unused',
            ]);

            // Generate QR PNG RAW
            $qrRaw = QrCode::format('png')->size(300)->generate($voucher->code);

            // Buat Data URI base64 lengkap
            $qrBase64 = "data:image/png;base64," . base64_encode($qrRaw);

            // Kirim email
            Mail::to($this->guest->email)->send(
                new VoucherNotification($this->guest, $qrBase64)
            );

            Log::info("Voucher {$code} berhasil dibuat untuk {$this->guest->email}.");

        } catch (\Exception $e) {
            Log::error("Error GenerateVoucherJob: " . $e->getMessage());
        }
    }
}
