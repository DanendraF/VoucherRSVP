<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-gray-600">Panel admin untuk mengelola voucher dan RSVP pernikahan</p>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Scan Voucher -->
                <a href="{{ route('voucher.scan') }}" class="block">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl shadow-lg p-6 hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Scan Voucher</h3>
                        <p class="text-purple-100 text-sm">Scan QR code voucher tamu untuk redeem diskon</p>
                        <div class="mt-4 flex items-center text-white text-sm font-semibold">
                            <span>Buka Scanner</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Lihat RSVP Form -->
                <a href="{{ route('rsvp.index') }}" class="block" target="_blank">
                    <div class="bg-gradient-to-br from-pink-500 to-pink-700 rounded-xl shadow-lg p-6 hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Form RSVP</h3>
                        <p class="text-pink-100 text-sm">Lihat halaman form RSVP untuk tamu undangan</p>
                        <div class="mt-4 flex items-center text-white text-sm font-semibold">
                            <span>Buka Form</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Statistik (Coming Soon) -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg p-6 opacity-75">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white bg-opacity-20 rounded-lg p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Statistik</h3>
                    <p class="text-blue-100 text-sm">Lihat statistik tamu dan voucher yang diredeem</p>
                    <div class="mt-4 flex items-center text-white text-sm font-semibold">
                        <span class="opacity-50">Coming Soon</span>
                    </div>
                </div>

            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

                <!-- Total RSVP -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold uppercase">Total RSVP</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Guest::count() }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">
                        Hadir: {{ \App\Models\Guest::where('rsvp_status', 'coming')->count() }} |
                        Tidak: {{ \App\Models\Guest::where('rsvp_status', 'not_coming')->count() }}
                    </p>
                </div>

                <!-- Voucher Dibuat -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold uppercase">Voucher Dibuat</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Voucher::count() }}</p>
                        </div>
                        <div class="bg-pink-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">
                        Belum dipakai: {{ \App\Models\Voucher::where('status', 'unused')->count() }}
                    </p>
                </div>

                <!-- Voucher Terpakai -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold uppercase">Voucher Terpakai</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Voucher::where('status', 'used')->count() }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">
                        Diredeem oleh staff
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
