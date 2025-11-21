<?php

namespace App\Mail;

use App\Models\Guest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VoucherNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $guest;
    public $qrCodeBase64;

    public function __construct(Guest $guest, string $qrCodeBase64)
    {
        $this->guest = $guest;
        $this->qrCodeBase64 = $qrCodeBase64;
    }

    public function build()
    {
        return $this->subject('Voucher Spesial Untuk Anda!')
                    ->view('emails.voucher');
    }
}
