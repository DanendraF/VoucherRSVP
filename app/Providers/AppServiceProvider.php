<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force QR Code to use GD backend instead of Imagick
        if (class_exists('\SimpleSoftwareIO\QrCode\Facades\QrCode')) {
            config(['simple-qrcode.backend' => 'gd']);
        }
    }
}
