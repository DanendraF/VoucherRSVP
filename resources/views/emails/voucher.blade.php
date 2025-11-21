<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Voucher Anda</title>
</head>
<body style="font-family: Arial, sans-serif; text-align: center;">

    <h2>Terima Kasih Telah RSVP, {{ $guest->name }}!</h2>

    <p>Sebagai ucapan terima kasih, kami berikan voucher diskon 10% untuk merchandise
    pernikahan kami.</p>

    <p>Tunjukkan QR Code di bawah ini kepada tim merchandise untuk menukarkannya.</p>

    <div style="margin: 30px 0;">
        <img 
            src="{{ $qrCodeBase64 }}" 
            alt="QR Code Voucher"
            style="width: 200px; height: 200px;"
        >
    </div>

    <p>Sampai jumpa di hari H!</p>

</body>
</html>
