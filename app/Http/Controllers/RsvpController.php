<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Voucher;
use App\Jobs\GenerateVoucherJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RsvpController extends Controller
{
    /**
     * Menampilkan form RSVP
     */
    public function index()
    {
        return view('rsvp.index');
    }

    /**
     * Menyimpan data RSVP
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:guests,email',
            'phone' => 'required|string|max:20',
            'rsvp_status' => 'required|in:coming,not_coming',
        ]);

        // Jika validasi gagal, redirect kembali dengan error
        if ($validator->fails()) {
            return redirect()->route('rsvp.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data tamu ke database
        $guest = Guest::create($request->all());

        // Jika tamu konfirmasi "Hadir", generate voucher via Job
        if ($guest->rsvp_status === 'coming') {
            GenerateVoucherJob::dispatch($guest);
        }

        // Redirect dengan success message
        return redirect()->route('rsvp.index')
            ->with('success', 'Terima kasih telah melakukan RSVP! Silakan cek email Anda untuk voucher.');
    }

    /**
     * Menampilkan halaman voucher (PUBLIC)
     */
    public function showVoucher($code)
    {
        // Cari voucher berdasarkan code
        $voucher = Voucher::where('code', $code)->firstOrFail();

        // Load relasi guest
        $guest = $voucher->guest;

        // Generate QR Code
        $qrcode = new \chillerlan\QRCode\QRCode();
        $qrCodeBase64 = $qrcode->render($voucher->code);

        return view('voucher.show', [
            'voucher' => $voucher,
            'guest' => $guest,
            'qrCodeBase64' => $qrCodeBase64
        ]);
    }
}
