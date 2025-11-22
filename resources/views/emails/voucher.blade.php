<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Diskon Anda</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 24px;
            color: #667eea;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .voucher-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin: 30px 0;
        }
        .voucher-box h2 {
            margin: 0 0 10px 0;
            font-size: 36px;
            font-weight: bold;
        }
        .voucher-box p {
            margin: 0;
            font-size: 18px;
            opacity: 0.9;
        }
        .voucher-code {
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 20px;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            font-weight: bold;
        }
        .cta-button {
            display: inline-block;
            background: #667eea;
            color: white;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            margin: 20px 0;
            transition: background 0.3s;
        }
        .cta-button:hover {
            background: #5568d3;
        }
        .instructions {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .instructions h3 {
            margin-top: 0;
            color: #667eea;
            font-size: 18px;
        }
        .instructions ol {
            margin: 10px 0;
            padding-left: 20px;
        }
        .instructions li {
            margin: 8px 0;
            color: #666;
        }
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #999;
            font-size: 14px;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🎉 Voucher Diskon Spesial</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo, {{ $guest->name }}! 👋
            </div>

            <div class="message">
                <p><strong>Terima kasih telah melakukan RSVP untuk pernikahan kami!</strong></p>
                <p>Sebagai bentuk apresiasi, kami memberikan voucher diskon <strong>10%</strong> untuk pembelian merchandise pernikahan.</p>
            </div>

            <!-- Voucher Info -->
            <div class="voucher-box">
                <h2>DISKON 10%</h2>
                <p>Merchandise Pernikahan</p>
                <div class="voucher-code">
                    {{ $voucherCode }}
                </div>
            </div>

            <!-- QR Code -->
            <div style="text-align: center; margin: 30px 0;">
                <div style="background: white; display: inline-block; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <img src="{{ $qrCodeBase64 }}" alt="QR Code Voucher" style="width: 200px; height: 200px; display: block;">
                </div>
                <p style="margin-top: 15px; color: #666; font-size: 14px;">
                    Scan QR Code ini atau klik tombol di bawah
                </p>
            </div>

            <!-- CTA Button -->
            <div style="text-align: center;">
                <a href="{{ $voucherLink }}" class="cta-button">
                    📱 Lihat Halaman Voucher
                </a>
            </div>

            <!-- Instructions -->
            <div class="instructions">
                <h3>📋 Cara Menggunakan Voucher:</h3>
                <ol>
                    <li>Tunjukkan QR Code di atas ke tim merchandise</li>
                    <li>Atau buka halaman voucher dengan klik tombol di atas</li>
                    <li>Dapatkan diskon 10% untuk pembelian Anda!</li>
                </ol>
                <p style="margin-top: 15px; color: #667eea; font-weight: 600;">
                    💡 Simpan email ini atau screenshot QR Code untuk digunakan nanti
                </p>
            </div>

            <div class="message">
                <p>Kami tunggu kehadiran Anda di hari istimewa kami! 💒</p>
                <p style="margin-top: 20px; font-style: italic; color: #999;">
                    Salam hangat,<br>
                    <strong style="color: #667eea;">Tim Wedding</strong>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Email ini dikirim otomatis, mohon tidak membalas.</p>
            <p>Jika ada pertanyaan, hubungi kami melalui WhatsApp yang telah dikirimkan.</p>
            <p style="margin-top: 15px;">&copy; 2024 Wedding RSVP System</p>
        </div>
    </div>
</body>
</html>
