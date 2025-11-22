<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Anda - {{ $voucher->code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        h1, h2 {
            font-family: 'Playfair Display', serif;
        }

        .voucher-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .qr-container {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 to-pink-50 min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white shadow-sm no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-purple-600">Wedding Voucher</h1>
                <a href="{{ route('rsvp.index') }}" class="text-sm text-gray-600 hover:text-purple-600">
                    ← Kembali ke RSVP
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-2xl mx-auto px-4 py-8 sm:py-12">

        <!-- Success Message -->
        <div class="text-center mb-8 no-print">
            <div class="inline-block bg-green-100 border-2 border-green-400 rounded-full px-6 py-3 mb-4">
                <svg class="inline-block w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-green-800 font-semibold">RSVP Berhasil!</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Terima Kasih, {{ $guest->name }}!</h2>
            <p class="text-gray-600">Voucher diskon Anda telah dibuat</p>
        </div>

        <!-- Voucher Card -->
        <div class="voucher-card rounded-3xl shadow-2xl p-8 text-white mb-6">
            <div class="text-center mb-8">
                <div class="inline-block bg-white bg-opacity-20 rounded-full px-6 py-2 mb-4">
                    <p class="text-sm font-semibold uppercase tracking-wider">Voucher Spesial</p>
                </div>
                <h3 class="text-4xl font-bold mb-2">Diskon 10%</h3>
                <p class="text-lg opacity-90">Merchandise Pernikahan</p>
            </div>

            <!-- QR Code -->
            <div class="qr-container mx-auto" style="width: fit-content;">
                <img
                    src="{{ $qrCodeBase64 }}"
                    alt="QR Code Voucher"
                    class="w-64 h-64 mx-auto"
                    id="qrcode-image"
                >
            </div>

            <!-- Voucher Code -->
            <div class="text-center mt-8">
                <p class="text-sm opacity-75 mb-2">Kode Voucher:</p>
                <div class="bg-white bg-opacity-20 rounded-lg px-6 py-3 inline-block">
                    <code class="text-2xl font-mono font-bold tracking-wider">{{ $voucher->code }}</code>
                </div>
            </div>

            <!-- Status -->
            <div class="text-center mt-6">
                @if($voucher->status === 'unused')
                    <span class="inline-block bg-green-500 bg-opacity-30 border-2 border-green-300 rounded-full px-4 py-1">
                        <span class="font-semibold">✓ Aktif</span>
                    </span>
                @elseif($voucher->status === 'used')
                    <span class="inline-block bg-gray-500 bg-opacity-30 border-2 border-gray-300 rounded-full px-4 py-1">
                        <span class="font-semibold">✗ Sudah Digunakan</span>
                    </span>
                @else
                    <span class="inline-block bg-red-500 bg-opacity-30 border-2 border-red-300 rounded-full px-4 py-1">
                        <span class="font-semibold">✗ Kadaluarsa</span>
                    </span>
                @endif
            </div>
        </div>

        <!-- Instructions -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Cara Menggunakan Voucher
            </h4>
            <ol class="space-y-3 text-gray-700">
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                    <span>Tunjukkan halaman ini atau screenshot QR code ke tim merchandise</span>
                </li>
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                    <span>Tim akan scan QR code untuk verifikasi voucher</span>
                </li>
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                    <span>Dapatkan diskon 10% untuk pembelian merchandise</span>
                </li>
            </ol>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 no-print">
            <button
                onclick="window.print()"
                class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-200 flex items-center justify-center"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Voucher
            </button>
            <button
                onclick="downloadQR()"
                class="bg-white hover:bg-gray-50 text-purple-600 font-semibold py-3 px-6 rounded-lg shadow-md border-2 border-purple-600 transition duration-200 flex items-center justify-center"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download QR Code
            </button>
        </div>

        <!-- Info Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm no-print">
            <p>Email konfirmasi telah dikirim ke <strong>{{ $guest->email }}</strong></p>
            <p class="mt-2">WhatsApp konfirmasi telah dikirim ke <strong>{{ $guest->phone }}</strong></p>
            <p class="mt-4 text-xs">Simpan halaman ini atau screenshot untuk digunakan nanti</p>
        </div>
    </div>

    <script>
        function downloadQR() {
            const qrImage = document.getElementById('qrcode-image');
            const link = document.createElement('a');
            link.href = qrImage.src;
            link.download = 'voucher-{{ $voucher->code }}.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>
