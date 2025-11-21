@echo off
title Wedding Voucher System - Starter

echo ========================================
echo   WEDDING VOUCHER SYSTEM
echo   Starting all servers...
echo ========================================
echo.

echo [1/2] Starting WhatsApp Server...
start "WhatsApp API Server" cmd /k "cd /d D:\Stematel\voucher && node whatsapp-server.js"

echo Waiting 5 seconds for WhatsApp to initialize...
timeout /t 5 /nobreak > nul

echo [2/2] Starting Laravel Server...
start "Laravel Server" cmd /k "cd /d D:\Stematel\voucher && php artisan serve"

echo.
echo ========================================
echo   ALL SERVERS STARTED!
echo ========================================
echo.
echo WhatsApp API: http://localhost:3000
echo Laravel App:  http://localhost:8000
echo.
echo Scan QR Code: http://localhost:3000/qr
echo RSVP Form:    http://localhost:8000/rsvp
echo.
echo ========================================
echo.
pause
