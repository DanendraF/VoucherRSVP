<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP Undangan Pernikahan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        h1, h2 {
            font-family: 'Playfair Display', serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .input-focus:focus {
            border-color: #667eea;
            ring-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-lg">
        <!-- Header Card -->
        <div class="text-center mb-8 fade-in">
            <div class="gradient-bg rounded-2xl shadow-2xl p-8 mb-6">
                <div class="text-white">
                    <div class="text-6xl mb-4">💒</div>
                    <h1 class="text-4xl font-bold mb-2">You're Invited!</h1>
                    <p class="text-lg opacity-90">Konfirmasi Kehadiran Anda</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 fade-in">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Form RSVP
            </h2>

            @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6 fade-in">
                <p class="font-semibold mb-2">Oops! Ada yang perlu diperbaiki:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 fade-in">
                <p class="font-semibold">✓ {{ session('success') }}</p>
            </div>
            @endif

            <form action="{{ route('rsvp.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        required
                        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg transition duration-200"
                        placeholder="Masukkan nama lengkap Anda"
                        value="{{ old('name') }}"
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        required
                        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg transition duration-200"
                        placeholder="contoh@email.com"
                        value="{{ old('email') }}"
                    >
                    <p class="text-xs text-gray-500 mt-1">Voucher akan dikirim ke email ini</p>
                </div>

                <!-- WhatsApp -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                        No. WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-4 bg-gray-100 border border-r-0 border-gray-300 rounded-l-lg text-gray-600">
                            +62
                        </span>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            required
                            class="input-focus flex-1 px-4 py-3 border border-gray-300 rounded-r-lg transition duration-200"
                            placeholder="812xxxxxxxx"
                            value="{{ old('phone') }}"
                        >
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Tanpa 0 atau +62, contoh: 81234567890</p>
                </div>

                <!-- Status Kehadiran -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Konfirmasi Kehadiran <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input
                                type="radio"
                                name="rsvp_status"
                                value="coming"
                                class="peer sr-only"
                                checked
                            >
                            <div class="border-2 border-gray-300 rounded-lg p-4 text-center peer-checked:border-purple-600 peer-checked:bg-purple-50 transition duration-200">
                                <div class="text-3xl mb-2">✅</div>
                                <p class="font-semibold text-gray-700">Hadir</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input
                                type="radio"
                                name="rsvp_status"
                                value="not_coming"
                                class="peer sr-only"
                            >
                            <div class="border-2 border-gray-300 rounded-lg p-4 text-center peer-checked:border-gray-600 peer-checked:bg-gray-50 transition duration-200">
                                <div class="text-3xl mb-2">❌</div>
                                <p class="font-semibold text-gray-700">Tidak Hadir</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-purple-50 border-l-4 border-purple-600 p-4 rounded">
                    <p class="text-sm text-purple-800">
                        <strong>💝 Bonus:</strong> Tamu yang hadir akan mendapatkan voucher diskon 10% untuk merchandise pernikahan!
                    </p>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full gradient-bg text-white font-semibold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200"
                >
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Konfirmasi Kehadiran
                    </span>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-600">
            <p class="text-sm">Terima kasih atas konfirmasi Anda! 🙏</p>
            <p class="text-xs mt-2 opacity-75">Wedding RSVP System &copy; 2024</p>
        </div>
    </div>

</body>
</html>
