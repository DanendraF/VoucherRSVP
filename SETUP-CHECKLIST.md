# ✅ Setup Checklist - Wedding Voucher System

Panduan cepat untuk yang baru clone project ini.

---

## 📋 **CHECKLIST INSTALASI**

### ☑️ **1. Prerequisites Check**
```bash
php --version     # Harus 8.1+
composer --version
node --version
npm --version
mysql --version
```

### ☑️ **2. Clone & Install Dependencies**
```bash
git clone <repository-url>
cd voucher
composer install
npm install
```

### ☑️ **3. Environment Setup**
```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env

# Generate key
php artisan key:generate
```

### ☑️ **4. Database Setup**
1. **Buat database:**
   ```sql
   CREATE DATABASE voucherlaravel;
   ```

2. **Edit `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=voucherlaravel
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

3. **Run migrations:**
   ```bash
   php artisan migrate
   ```

### ☑️ **5. Email Setup (Choose One)**

#### **Option A: Gmail (Production)**
1. Enable 2FA: https://myaccount.google.com/security
2. Generate App Password: https://myaccount.google.com/apppasswords
3. Update `.env`:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your_email@gmail.com
   MAIL_PASSWORD=your_16_digit_app_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="your_email@gmail.com"
   MAIL_FROM_NAME="Wedding RSVP System"
   ```

#### **Option B: Mailtrap (Testing)**
1. Signup: https://mailtrap.io
2. Update `.env`:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mailtrap_username
   MAIL_PASSWORD=your_mailtrap_password
   ```

### ☑️ **6. WhatsApp Setup**
Update `.env`:
```env
WAHA_BASE_URL=http://localhost:3000
WAHA_SESSION_NAME=default
WAHA_API_KEY=
```

### ☑️ **7. Clear Cache**
```bash
php artisan config:clear
php artisan cache:clear
```

### ☑️ **8. Create Admin User**
```bash
php artisan tinker
```

Di tinker, jalankan:
```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@wedding.com',
    'password' => bcrypt('password123')
]);
```

Tekan `Ctrl+C` untuk keluar.

### ☑️ **9. Run Application**

**Windows:**
```bash
# Double-click
start-all.bat
```

**Manual (2 terminals):**

Terminal 1 - WhatsApp:
```bash
node whatsapp-server.js
```

Terminal 2 - Laravel:
```bash
php artisan serve
```

### ☑️ **10. Test Setup**

#### **Test WhatsApp Connection:**
1. Buka: http://localhost:3000/qr
2. Scan QR code dengan WhatsApp di HP kamu
3. Tunggu sampai muncul "✅ WhatsApp Ready!"

#### **Test Email:**
1. Buka: http://localhost:8000/rsvp
2. Isi form dengan:
   - Nama: Test User
   - Email: your_email@gmail.com
   - Phone: 081234567890
   - Status: Saya akan datang
3. Submit
4. Cek email masuk

#### **Test Admin Panel:**
1. Buka: http://localhost:8000/login
2. Login dengan:
   - Email: admin@wedding.com
   - Password: password123

---

## 🐛 **Quick Troubleshooting**

### **Error: "No application encryption key"**
```bash
php artisan key:generate
```

### **Error: "Access denied for user"**
Cek `.env` → username/password database salah

### **Error: "Class not found"**
```bash
composer dump-autoload
```

### **Email tidak masuk:**
```bash
php artisan config:clear
rm bootstrap/cache/config.php  # Hapus manual
```

### **WhatsApp tidak terkirim:**
- Cek server running: http://localhost:3000/status
- Pastikan QR sudah di-scan

---

## 📚 **Dokumentasi Lengkap**

- **README.md** - Full documentation
- **WHATSAPP-SETUP.md** - WhatsApp integration guide
- **QUICK-START-WAHA.md** - Quick 3-minute WhatsApp setup

---

## 🎯 **URLs Penting**

| Service | URL |
|---------|-----|
| Laravel App | http://localhost:8000 |
| RSVP Form | http://localhost:8000/rsvp |
| Admin Login | http://localhost:8000/login |
| WhatsApp Server | http://localhost:3000 |
| WhatsApp QR Scan | http://localhost:3000/qr |
| WhatsApp Status | http://localhost:3000/status |

---

## ✅ **Installation Complete!**

Selamat! Project sudah siap digunakan.

**Next steps:**
1. Test RSVP form
2. Customize email template di `resources/views/emails/voucher.blade.php`
3. Customize RSVP form di `resources/views/rsvp/index.blade.php`
4. Deploy to production (lihat README.md section Deployment)

---

**Happy Wedding! 🎉💒**
