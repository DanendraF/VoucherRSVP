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
    public $voucherCode;
    public $voucherLink;

    public function __construct(Guest $guest, string $voucherCode, string $voucherLink)
    {
        $this->guest = $guest;
        $this->voucherCode = $voucherCode;
        $this->voucherLink = $voucherLink;
    }

    public function build()
    {
        return $this->subject('🎉 Voucher Diskon 10% - Terima Kasih Telah RSVP!')
                    ->view('emails.voucher');
    }
}
