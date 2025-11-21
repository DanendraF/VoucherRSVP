# 💒 Wedding Voucher System

Laravel application untuk manajemen RSVP pernikahan dengan voucher diskon otomatis, QR code, notifikasi email & WhatsApp.

---

## ✨ **FEATURES**

- 📝 **RSVP Form** - Form konfirmasi kehadiran tamu
- 🎟️ **Auto Voucher Generation** - Generate voucher diskon 10% otomatis
- 📱 **QR Code** - Unique QR code untuk setiap voucher
- 📧 **Email Notification** - Kirim email dengan QR code embedded
- 💬 **WhatsApp Integration** - Kirim voucher via WhatsApp
- 🔍 **QR Scanner** - Staff bisa scan & redeem voucher
- 📊 **Dashboard** - Admin panel untuk staff

---

## 🛠️ **TECH STACK**

- **Backend:** Laravel 10 + PHP 8.1+
- **Database:** MySQL
- **Auth:** Laravel Breeze
- **Email:** SMTP (Mailtrap configured)
- **WhatsApp:** whatsapp-web.js + Express.js
- **QR Code:** SimpleSoftwareIO/simple-qrcode
- **QR Scanner:** Html5QrcodeScanner
- **Frontend:** Blade + Tailwind CSS

---

## 🚀 **QUICK START**

### **Prerequisites**
- PHP 8.1+ (dengan extension: `gd`, `mbstring`, `pdo_mysql`, `fileinfo`)
- Composer
- Node.js & NPM
- MySQL 5.7+ atau MariaDB 10.3+

### **Installation (Clone Project)**

Jika kamu clone project ini, ikuti langkah-langkah berikut:

```bash
# 1. Clone repository
git clone <repository-url>
cd voucher

# 2. Install PHP dependencies
composer install

# 3. Install Node.js dependencies
npm install

# 4. Setup environment file
copy .env.example .env
# Untuk Linux/Mac: cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure database (.env)
# Edit .env dan isi:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=voucherlaravel
DB_USERNAME=root
DB_PASSWORD=your_password

# 7. Create database
# Buat database 'voucherlaravel' di MySQL

# 8. Run migrations
php artisan migrate

# 9. Configure email (.env)
# Pilih salah satu:

# Option A - Gmail (Production):
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password  # Buat di Google Account
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your_email@gmail.com"
MAIL_FROM_NAME="Wedding RSVP System"

# Option B - Mailtrap (Testing):
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password

# 10. Configure WhatsApp (.env)
WAHA_BASE_URL=http://localhost:3000
WAHA_SESSION_NAME=default
WAHA_API_KEY=

# 11. Clear config cache
php artisan config:clear
php artisan cache:clear

# 12. Create admin user
php artisan tinker
# Lalu di tinker, jalankan:
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@wedding.com',
    'password' => bcrypt('password123')
]);
# Tekan Ctrl+C untuk keluar

# 13. Done! 🎉
```

### **Running the Application**

**Cara Mudah:** Double-click `start-all.bat`

**Atau manual:**

Terminal 1 (WhatsApp):
```bash
node whatsapp-server.js
```
Scan QR di http://localhost:3000/qr

Terminal 2 (Laravel):
```bash
php artisan serve
```

**Access:**
- Laravel App: http://localhost:8000
- WhatsApp API: http://localhost:3000
- RSVP Form: http://localhost:8000/rsvp

---

## 📚 **DOCUMENTATION**

| File | Description |
|------|-------------|
| **[SETUP-CHECKLIST.md](SETUP-CHECKLIST.md)** | ⭐ Quick setup checklist (clone project) |
| **[QUICK-START-WAHA.md](QUICK-START-WAHA.md)** | Setup WhatsApp (3 menit) |
| **[WHATSAPP-SETUP.md](WHATSAPP-SETUP.md)** | Dokumentasi WhatsApp lengkap |
| `start-all.bat` | Start semua server otomatis |

---

## 🎯 **HOW IT WORKS**

### **RSVP Flow:**

```
Tamu isi form RSVP
    ↓
Status = "Datang" ?
    ↓ YES
Generate Voucher
    ├─ Unique code: WEDD-VOUCHER-XXXXX
    ├─ QR Code (PNG 300x300)
    ├─ Send Email (Mailtrap)
    └─ Send WhatsApp (whatsapp-web.js)
    ↓
Tamu terima Email + WhatsApp
```

### **Redemption Flow:**

```
Staff login → Scan Voucher
    ↓
Kamera scan QR code
    ↓
Validasi voucher
    ├─ Exists?
    ├─ Status = unused?
    └─ Not expired?
    ↓ ALL VALID
Update: status = used
    ↓
Tamu dapat diskon 10%!
```

---

## 📁 **PROJECT STRUCTURE**

```
voucher/
├── app/
│   ├── Http/Controllers/
│   │   ├── RsvpController.php
│   │   ├── VoucherRedeemController.php
│   │   └── VoucherScanController.php
│   ├── Jobs/
│   │   └── GenerateVoucherJob.php
│   ├── Mail/
│   │   └── VoucherNotification.php
│   └── Models/
│       ├── Guest.php
│       ├── Voucher.php
│       └── User.php
├── config/services.php
├── resources/views/
│   ├── rsvp/index.blade.php
│   ├── emails/voucher.blade.php
│   └── admin/scan.blade.php
├── whatsapp-server.js
├── start-all.bat
└── .env
```

---

## ⚙️ **CONFIGURATION**

### **Gmail Setup (untuk Email Production)**

Jika ingin pakai Gmail untuk kirim email real:

1. **Enable 2-Factor Authentication** di Google Account
   - Buka: https://myaccount.google.com/security
   - Enable "2-Step Verification"

2. **Generate App Password**
   - Buka: https://myaccount.google.com/apppasswords
   - Pilih app: "Mail"
   - Pilih device: "Other" → Isi nama: "Laravel Wedding"
   - Klik "Generate"
   - Copy 16-digit password yang muncul

3. **Update .env**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your_email@gmail.com
   MAIL_PASSWORD=xxxx xxxx xxxx xxxx  # 16-digit App Password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="your_email@gmail.com"
   MAIL_FROM_NAME="Wedding RSVP System"
   ```

4. **Clear cache**
   ```bash
   php artisan config:clear
   ```

### **.env Variables (Complete)**

```env
# App
APP_NAME="Wedding Voucher"
APP_ENV=local
APP_KEY=base64:xxxxx
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=voucherlaravel
DB_USERNAME=root
DB_PASSWORD=your_password

# Email - Gmail (Production)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your_email@gmail.com"
MAIL_FROM_NAME="Wedding RSVP System"

# Email - Mailtrap (Testing)
# MAIL_MAILER=smtp
# MAIL_HOST=smtp.mailtrap.io
# MAIL_PORT=2525
# MAIL_USERNAME=your_mailtrap_username
# MAIL_PASSWORD=your_mailtrap_password

# WhatsApp
WAHA_BASE_URL=http://localhost:3000
WAHA_SESSION_NAME=default
WAHA_API_KEY=
```

---

## 🧪 **TESTING**

### **Test RSVP & Voucher Generation:**

1. Jalankan server (`start-all.bat`)
2. Scan QR WhatsApp (http://localhost:3000/qr)
3. Buka: http://localhost:8000/rsvp
4. Isi form dengan **nomor HP Anda**
5. Pilih "Saya akan datang"
6. Submit
7. Cek:
   - ✅ Email masuk (Mailtrap inbox)
   - ✅ WhatsApp terima QR code

### **Test Voucher Redemption:**

1. Login staff: http://localhost:8000/login
2. Dashboard → Scan Voucher
3. Kamera aktif → Scan QR code
4. Status: "Voucher berhasil digunakan!"

---

## 📊 **DATABASE SCHEMA**

### **guests**
- id, name, email (unique), phone, rsvp_status, timestamps

### **vouchers**
- id, guest_id (FK), code (unique), discount_percentage (10)
- status (unused/used/expired), used_at, redeemed_by (FK users)
- expires_at, timestamps

### **users**
- id, name, email, password, timestamps (Staff/Admin)

---

## 🔐 **DEFAULT USERS**

Belum ada seeder. Buat user manual:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@wedding.com',
    'password' => bcrypt('password123')
]);
```

Login: admin@wedding.com / password123

---

## 🚨 **TROUBLESHOOTING**

### **Error: "No application encryption key has been specified"**
```bash
php artisan key:generate
php artisan config:clear
```

### **Error: "SQLSTATE[HY000] [1045] Access denied for user"**
1. Cek username/password database di `.env`
2. Pastikan database `voucherlaravel` sudah dibuat
3. Test koneksi MySQL:
   ```bash
   mysql -u root -p
   ```

### **Error: "Class 'App\Jobs\GenerateVoucherJob' not found"**
```bash
composer dump-autoload
php artisan config:clear
```

### **Error: "You need to install the imagick extension"**
Sudah fixed! Project ini pakai `chillerlan/php-qrcode` yang hanya butuh extension `gd`.

Cek extension `gd` sudah aktif:
```bash
php -m | grep gd
```

Jika belum ada, enable di `php.ini`:
```ini
extension=gd
```

### **Email tidak masuk sama sekali:**
1. **Cek config cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

2. **Cek .env dibaca dengan benar:**
   ```bash
   php artisan tinker
   config('mail.host')  # Harus muncul smtp.gmail.com
   config('mail.username')  # Harus muncul email Anda
   exit
   ```

3. **Hapus manual config cache:**
   ```bash
   # Windows
   del bootstrap\cache\config.php

   # Linux/Mac
   rm bootstrap/cache/config.php
   ```

4. **Cek log Laravel:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

### **QR Code tidak muncul di email:**
- **Native Mail app (iOS/Mac/Outlook):** ✅ Akan muncul langsung
- **Gmail web/app:** ⚠️ Perlu klik "Display images" dulu
- **Alasan:** Gmail blokir data URI images untuk keamanan
- **Solusi production:** Host QR code di server public (S3, Cloudinary, dll)

### **WhatsApp tidak terkirim:**
1. Cek WhatsApp server running: http://localhost:3000/status
2. Pastikan QR WhatsApp sudah di-scan di http://localhost:3000/qr
3. Cek log Laravel: `storage/logs/laravel.log`
4. Pastikan nomor HP format Indonesia: 081234567890 (tanpa +62)

### **QR Scanner tidak jalan:**
1. Allow camera permission di browser
2. Gunakan HTTPS (production) atau localhost (dev)
3. Test kamera: buka http://localhost:8000/scan (jika ada route scan)

---

## 📦 **DEPLOYMENT**

### **Production Checklist:**

- [ ] Ganti `APP_ENV=production` di `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Ganti Mailtrap ke real SMTP (Gmail, SendGrid, dll)
- [ ] Deploy WhatsApp server ke VPS (DigitalOcean, AWS)
- [ ] Setup SSL/HTTPS
- [ ] Optimize: `php artisan optimize`
- [ ] Setup queue worker: `php artisan queue:work`

---

## 📝 **LICENSE**

MIT License - Free to use and modify

---

## 📞 **SUPPORT**

Jika ada error atau butuh bantuan:
1. Cek **[WHATSAPP-SETUP.md](WHATSAPP-SETUP.md)** untuk troubleshooting WhatsApp
2. Cek **[QUICK-START-WAHA.md](QUICK-START-WAHA.md)** untuk setup cepat
3. Lihat log: `storage/logs/laravel.log`

---

**Happy Wedding! 🎉💒**
