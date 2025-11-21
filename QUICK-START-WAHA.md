# ⚡ QUICK START - WhatsApp Integration

Panduan super cepat (3 menit) untuk setup WhatsApp.

---

## ✅ **SUDAH SELESAI!**

Semua file sudah di-setup:
- ✅ `whatsapp-server.js` - Server WhatsApp API
- ✅ Dependencies installed
- ✅ `.env` configured

**Tinggal jalankan!** 🚀

---

## 🚀 **3 LANGKAH MUDAH**

### **1. Start WhatsApp Server**

```bash
cd D:\Stematel\voucher
node whatsapp-server.js
```

Tunggu QR code muncul di terminal.

---

### **2. Scan QR Code**

**Cara termudah:** Buka browser **http://localhost:3000/qr**

QR code muncul besar → Scan dengan WhatsApp (Settings → Linked Devices)

**Output sukses:**
```
✅ WhatsApp Client is READY!
📱 Connected as: Your Name
```

**⚠️ Jangan tutup terminal!** Biarkan running.

---

### **3. Start Laravel**

Buka terminal baru:

```bash
cd D:\Stematel\voucher
php artisan serve
```

**DONE! Sistem sudah ready!** 🎉

---

## 🧪 **TESTING**

1. Buka: **http://localhost:8000/rsvp**
2. Isi form dengan **nomor HP Anda sendiri**
3. Pilih: **✅ Saya akan datang**
4. Submit
5. **Cek WhatsApp** → Terima QR code voucher! 📱

---

## 🖥️ **CARA PRAKTIS: Start Semua Sekaligus**

Buat file `start-all.bat` di folder project:

```batch
@echo off
start "WhatsApp" cmd /k "node whatsapp-server.js"
timeout /t 5
start "Laravel" cmd /k "php artisan serve"
```

Double-click → Semua server jalan otomatis! 🚀

---

## ⚠️ **TROUBLESHOOTING CEPAT**

| Masalah | Solusi |
|---------|--------|
| QR code gak muncul | Ctrl+C → Hapus folder `.wwebjs_auth` → Jalankan lagi |
| "Not ready" | Scan QR code dulu di http://localhost:3000/qr |
| Port 3000 used | Edit `.env`: `WAHA_PORT=3001` |
| WA gak terkirim | Cek log: `storage\logs\laravel.log` |

---

## 📚 **Dokumentasi Lengkap**

Lihat: **[WHATSAPP-SETUP.md](WHATSAPP-SETUP.md)**

---

**Happy testing! 🎉**
