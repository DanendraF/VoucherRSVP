# 📱 WhatsApp Integration - Setup Guide

Panduan lengkap integrasi WhatsApp di project Laravel Wedding Voucher menggunakan `whatsapp-web.js`.

---

## ✅ **SUDAH SELESAI - Ready to Use!**

File sudah di-setup dan siap digunakan:
- ✅ `whatsapp-server.js` - WhatsApp API server
- ✅ Dependencies installed (`whatsapp-web.js`, `express`, `qrcode`)
- ✅ Config `.env` sudah siap

---

## 🚀 **CARA MENGGUNAKAN (3 LANGKAH)**

### **Step 1: Jalankan WhatsApp Server**

Buka terminal baru dan jalankan:

```bash
cd D:\Stematel\voucher
node whatsapp-server.js
```

**Output yang akan muncul:**
```
🚀 Starting WhatsApp API Server...
🌐 HTTP API Server listening on port 3000
📖 Open browser: http://localhost:3000
⏳ Waiting for WhatsApp to connect...

🔥 WhatsApp QR Code Generated!
📱 Scan QR code ini dengan WhatsApp Anda:

  [QR CODE MUNCUL DI TERMINAL]

✅ Atau buka browser: http://localhost:3000/qr
```

**⚠️ PENTING:** Jangan tutup terminal ini! Biarkan tetap running.

---

### **Step 2: Scan QR Code**

**Pilihan A: Scan langsung dari terminal**
- QR code sudah muncul di terminal
- Buka WhatsApp → Settings → Linked Devices → Link a Device
- Scan QR code

**Pilihan B: Scan via browser (lebih mudah)**
1. Buka browser: **http://localhost:3000/qr**
2. QR code muncul lebih besar dan jelas
3. Scan dengan WhatsApp

**Setelah sukses scan:**
```
✅ WhatsApp Client is READY!
🌐 API Server running on: http://localhost:3000
📱 Connected as: Your Name
📞 Phone: 628xxxxxxxxx
```

---

### **Step 3: Jalankan Laravel**

Buka terminal baru (jangan tutup terminal WhatsApp server):

```bash
cd D:\Stematel\voucher
php artisan serve
```

Laravel running di: **http://localhost:8000**

---

## 🧪 **TESTING**

### **Test 1: Cek Status Connection**

Buka browser: **http://localhost:3000/status**

Response jika connected:
```json
{
  "status": "CONNECTED",
  "ready": true,
  "info": {
    "pushname": "Your Name",
    "wid": {
      "user": "628xxxxxxxxx"
    }
  }
}
```

---

### **Test 2: Kirim Pesan Test via Browser**

1. Buka browser: **http://localhost:3000**
2. Lihat API documentation
3. Test dengan Postman atau cURL:

**Kirim Text:**
```bash
curl -X POST http://localhost:3000/api/sessions/default/messages \
  -H "Content-Type: application/json" \
  -d "{\"chatId\":\"6281234567890@c.us\",\"text\":\"Test dari Laravel!\"}"
```
**Ganti `6281234567890` dengan nomor HP Anda!**

---

### **Test 3: Test RSVP Form (Full Integration)**

1. Buka: **http://localhost:8000/rsvp**
2. Isi form:
   - **Nama:** Test User
   - **Email:** test@example.com
   - **WhatsApp:** +6281234567890 (nomor Anda)
   - **Status:** ✅ Saya akan datang
3. Submit
4. **Cek WhatsApp Anda** → Akan terima gambar QR code voucher! 🎉

---

## 📋 **FILE STRUCTURE**

```
D:\Stematel\voucher/
├── whatsapp-server.js          ← WhatsApp API server (baru)
├── .env                         ← Config (WAHA_BASE_URL sudah ada)
├── app/
│   └── Jobs/
│       └── GenerateVoucherJob.php  ← Kirim WA dari sini
├── node_modules/                ← Dependencies
└── package.json                 ← NPM packages
```

---

## ⚙️ **KONFIGURASI**

File `.env` sudah configured:

```env
WAHA_BASE_URL=http://localhost:3000
WAHA_SESSION_NAME=default
WAHA_API_KEY=
```

**Tidak perlu diubah!** ✅

---

## 🔍 **TROUBLESHOOTING**

### **1. Error: "Cannot find module 'whatsapp-web.js'"**

**Solusi:**
```bash
cd D:\Stematel\voucher
npm install
```

---

### **2. QR Code tidak muncul / stuck**

**Solusi:**
1. Stop server (Ctrl+C)
2. Hapus folder session:
   ```bash
   rmdir /s .wwebjs_auth
   ```
3. Jalankan lagi:
   ```bash
   node whatsapp-server.js
   ```

---

### **3. Error: "WhatsApp client is not ready"**

**Penyebab:** QR code belum di-scan atau connection lost

**Solusi:**
1. Cek terminal WhatsApp server
2. Jika ada QR code → Scan lagi
3. Cek status: http://localhost:3000/status
4. Jika status "DISCONNECTED" → Restart server

---

### **4. Pesan WhatsApp tidak terkirim**

**Cek Log Laravel:**
```bash
notepad storage\logs\laravel.log
```

Cari baris error, kemungkinan:
- Format nomor salah (harus `628xxx@c.us`)
- WhatsApp server belum ready
- Nomor tidak valid / tidak terdaftar WA

**Cek Log WhatsApp Server:**
Lihat terminal tempat `whatsapp-server.js` running, cari error message.

---

### **5. Error: "Port 3000 already in use"**

**Penyebab:** Ada service lain di port 3000

**Solusi A: Ganti port**

Edit `.env`:
```env
WAHA_PORT=3001
WAHA_BASE_URL=http://localhost:3001
```

Jalankan dengan custom port:
```bash
set WAHA_PORT=3001 && node whatsapp-server.js
```

**Solusi B: Kill process yang pakai port 3000**
```bash
netstat -ano | findstr :3000
taskkill /PID [PID_NUMBER] /F
```

---

## 🎯 **WORKFLOW LENGKAP**

```
Terminal 1: WhatsApp Server
┌─────────────────────────────────────────┐
│ cd D:\Stematel\voucher                  │
│ node whatsapp-server.js                 │
│ [Scan QR Code]                          │
│ Status: CONNECTED ✅                    │
│ [Keep Running - Jangan tutup!]         │
└─────────────────────────────────────────┘
                ↓ HTTP API

Terminal 2: Laravel
┌─────────────────────────────────────────┐
│ cd D:\Stematel\voucher                  │
│ php artisan serve                       │
│ Server: http://localhost:8000           │
└─────────────────────────────────────────┘
                ↓

Browser: RSVP Form
┌─────────────────────────────────────────┐
│ http://localhost:8000/rsvp              │
│ [Isi Form] → Submit                     │
└─────────────────────────────────────────┘
                ↓

Laravel Job: GenerateVoucherJob
┌─────────────────────────────────────────┐
│ 1. Generate voucher code                │
│ 2. Generate QR code (base64)            │
│ 3. Send Email (Mailtrap)                │
│ 4. Send WhatsApp via HTTP POST          │
│    → http://localhost:3000/api/...     │
└─────────────────────────────────────────┘
                ↓

WhatsApp Server
┌─────────────────────────────────────────┐
│ Receive HTTP request                    │
│ Convert base64 → WhatsApp message       │
│ Send via whatsapp-web.js                │
└─────────────────────────────────────────┘
                ↓

Guest's WhatsApp
┌─────────────────────────────────────────┐
│ 📱 Receive message with QR code         │
│ ✅ Voucher delivered!                   │
└─────────────────────────────────────────┘
```

---

## 💡 **TIPS PENGGUNAAN**

### **1. Auto-start dengan Batch File**

Buat file `start-all.bat`:

```batch
@echo off
echo Starting WhatsApp Server...
start "WhatsApp Server" cmd /k "cd /d D:\Stematel\voucher && node whatsapp-server.js"

timeout /t 5

echo Starting Laravel...
start "Laravel Server" cmd /k "cd /d D:\Stematel\voucher && php artisan serve"

echo.
echo ===================================
echo Servers are starting...
echo WhatsApp: http://localhost:3000
echo Laravel:  http://localhost:8000
echo ===================================
```

Double-click `start-all.bat` untuk jalankan kedua server sekaligus!

---

### **2. Session Persistence**

Session WhatsApp tersimpan di folder `.wwebjs_auth/`:
- ✅ **Jangan hapus folder ini!**
- ✅ QR code hanya perlu di-scan **1x**
- ✅ Session akan tetap login setelah restart

**Backup session (optional):**
```bash
xcopy .wwebjs_auth .wwebjs_auth_backup /E /I
```

---

### **3. Development vs Production**

**Development (Sekarang):**
- WhatsApp server running lokal
- Perfect untuk testing
- Gratis, simple, cepat

**Production (Wedding Day):**
- **Opsi A:** Laptop tetap online selama event
- **Opsi B:** Deploy ke VPS (recommended)
  - DigitalOcean, Vultr, AWS ($5-10/bulan)
  - Upload `whatsapp-server.js` ke VPS
  - Install Node.js di VPS
  - Jalankan dengan PM2 (24/7)

---

## 🔐 **SECURITY NOTES**

### **Untuk Production:**

1. **Tambahkan API Key authentication:**

Edit `whatsapp-server.js`, tambahkan middleware:
```javascript
const API_KEY = process.env.WAHA_API_KEY || 'your-secret-key';

app.use('/api/*', (req, res, next) => {
    const apiKey = req.headers['x-api-key'];
    if (apiKey !== API_KEY) {
        return res.status(401).json({ error: 'Unauthorized' });
    }
    next();
});
```

Update `.env`:
```env
WAHA_API_KEY=your-super-secret-key-12345
```

2. **Gunakan HTTPS** (jika deploy ke VPS)
3. **Firewall:** Hanya allow IP Laravel server
4. **Rate limiting:** Batasi request per menit

---

## 📚 **API ENDPOINTS**

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/` | GET | Homepage & documentation |
| `/status` | GET | Check connection status |
| `/qr` | GET | View QR code (if not connected) |
| `/health` | GET | Health check |
| `/api/sessions/default/status` | GET | Session status (WAHA-compatible) |
| `/api/sessions/default/messages` | POST | Send message (WAHA-compatible) |

---

## 🎓 **REFERENCES**

- **whatsapp-web.js:** https://github.com/pedroslopez/whatsapp-web.js
- **Express.js:** https://expressjs.com/
- **Laravel Docs:** https://laravel.com/docs

---

## ✅ **CHECKLIST BEFORE TESTING**

- [x] Dependencies installed (`npm install` done)
- [x] `whatsapp-server.js` created
- [x] `.env` configured with `WAHA_BASE_URL`
- [ ] WhatsApp server running (`node whatsapp-server.js`)
- [ ] QR code scanned & status CONNECTED
- [ ] Laravel running (`php artisan serve`)
- [ ] Test RSVP dengan nomor HP sendiri

---

**Ready to test! 🚀**

Jika ada error, cek section **Troubleshooting** di atas.
