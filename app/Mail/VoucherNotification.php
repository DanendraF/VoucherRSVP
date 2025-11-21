<?php

namespace App\Mail;

use App\Models\Guest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
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

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Voucher Spesial Untuk Anda!',
        );
    }

    public function content(): Content
{
    return new Content(
        view: 'emails.voucher',
        with: [
            'guest' => $this->guest,
            'qrCodeBase64' => $this->qrCodeBase64, // WAJIB ADA!
        ],
    );
}


    public function attachments(): array
    {
        return [];
    }
}
