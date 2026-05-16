# ♻️ E-Waste Hub — Platform Pengelolaan Sampah Elektronik

Sistem manajemen sampah elektronik berbasis web yang menghubungkan masyarakat dengan mitra pengepul untuk pengelolaan e-waste yang lebih baik.

---

## 📋 Fitur Utama

### 👥 Kontributor (Masyarakat)
- **Request E-Waste** — Buat permintaan penjemputan sampah elektronik
- **Riwayat Transaksi** — Track semua request yang pernah dibuat
- **Sistem Poin** — Dapatkan 100 poin per kg e-waste yang diserahkan
- **Reward** — Konversi poin ke saldo (1 poin = Rp 75)

### 🚚 Mitra (Pengepul)
- **Daftar Tugas** — Lihat request e-waste yang tersedia
- **Ambil Order** — Klaim tugas dan hubungi kontributor via WhatsApp
- **Update Status** — Kelola status order (diambil, diproses, selesai)
- **Riwayat & Pendapatan** — Track pengambilan dan estimasi pendapatan (Rp 5.000/kg)

### 🛡️ Admin
- **Dashboard Monitoring** — Statistik sistem dan chart transaksi
- **Kelola Pengguna** — Approve/reject mitra baru
- **CRUD Kategori** — Kelola kategori e-waste dinamis
- **Laporan Transaksi** — Lihat semua transaksi lengkap
- **Pengaturan Sistem** — Atur poin, harga, dan profil admin

---

## 🛠️ Tech Stack

- **Backend**: Laravel 11.x (PHP 8.2+)
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Auth + Middleware
- **Authorization**: Laravel Gates & Policies

---

## 📦 Instalasi

### 1️⃣ Clone & Install Dependencies

```bash
# Clone repository
git clone <repository-url> uas-web
cd uas-web

# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2️⃣ Setup Environment

```bash
# Copy .env file
copy .env.example .env    # Windows
cp .env.example .env      # Mac/Linux

# Generate app key
php artisan key:generate
```

### 3️⃣ Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=uas_web
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Setup Database

```bash
# Jalankan migration
php artisan migrate

# Seed data (admin, kontributor, mitra, categories)
php artisan db:seed
```

### 5️⃣ Build Assets

```bash
# Development (auto-reload)
npm run dev

# Production (optimized)
npm run build
```

### 6️⃣ Jalankan Server

```bash
# Laravel built-in server
php artisan serve

# Akses di: http://localhost:8000
```

---

## 🔑 Default Login

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@example.com | 112233 |
| **Kontributor** | kontributor@example.com | 112233 |
| **Mitra** | mitra@example.com | 112233 |

---

## 📁 Struktur Database

### Tabel Utama (4 tabel)

```
users
├── id, name, email, password, phone, role (admin/masyarakat/mitra)
├── nama_lapak, alamat_lapak (untuk mitra)
└── is_approved (approval mitra oleh admin)

categories
├── id, name
└── Relasi: hasMany → ewaste_requests

ewaste_requests
├── id, user_id, mitra_id, category_id
├── kategori (legacy), berat, alamat, catatan, foto
├── status (menunggu, diambil, diproses, selesai, dibatalkan)
└── timestamps

cache, jobs, sessions (Laravel default)
```

### Relasi Database

```
User (Kontributor) ──1:N──> EwasteRequest
User (Mitra) ──1:N──> EwasteRequest
Category ──1:N──> EwasteRequest
```

---

## 🎯 Cara Pakai

### Kontributor Dashboard

1. Login sebagai kontributor
2. **Dashboard** → Lihat statistik poin dan request terbaru
3. **Request Saya** → Buat request baru dengan kategori, berat, alamat
4. **Riwayat** → Lihat semua transaksi dan status
5. **Poin & Reward** → Cek total poin dan estimasi saldo

### Mitra Dashboard

1. Login sebagai mitra (harus sudah di-approve admin)
2. **Dashboard** → Lihat tugas tersedia dan order aktif
3. **Daftar Tugas** → Ambil tugas dari request yang menunggu
4. **Riwayat** → Track pengambilan dan total pendapatan
5. **Scan QR** → Fitur verifikasi transaksi (coming soon)

### Admin Panel

1. Login sebagai admin
2. **Dashboard** → Monitoring statistik dan chart
3. **Transaksi** → Lihat semua transaksi sistem
4. **Pengguna** → Approve/reject mitra baru
5. **Laporan** → Export data transaksi selesai
6. **Pengaturan** → CRUD kategori, atur poin & harga

---

## 💰 Sistem Poin & Reward

### Kontributor
- **Poin**: 100 poin per kg e-waste yang diserahkan
- **Konversi**: 1 poin = Rp 75
- **Contoh**: 5 kg e-waste = 500 poin = Rp 37.500

### Mitra
- **Estimasi Pendapatan**: Rp 5.000 per kg e-waste
- **Contoh**: 10 kg e-waste = Rp 50.000

### Perhitungan Otomatis
```php
// Total Poin Kontributor
$totalPoin = EwasteRequest::where('user_id', $userId)
    ->where('status', 'selesai')
    ->sum('berat') * 100;

// Estimasi Saldo
$saldo = $totalPoin * 75;

// Pendapatan Mitra
$pendapatan = $totalBerat * 5000;
```

---

## 📦 Kategori E-Waste Default

- Laptop & Komputer
- Smartphone
- TV & Monitor
- Baterai & Aki
- Perangkat Jaringan
- Lainnya

*Kategori dapat dikelola oleh admin melalui halaman pengaturan (CRUD)*

---

## 🎨 Design System

### Warna
- **Primary**: Emerald Green (#10b981)
- **Background**: White (#ffffff)
- **Cards**: Slate-50/100
- **Text**: Slate-700/800

### Komponen
- Rounded cards dengan border subtle
- Status badges dengan warna dinamis
- Responsive grid layout
- Modal untuk edit kategori

---

## 📝 Routes

### Guest

```
GET  /              → landing page
GET  /login         → login form
POST /login         → authenticate
GET  /register      → register form
POST /register      → create account
```

### Kontributor (auth + role:masyarakat)

```
GET    /user/dashboard           → main dashboard
GET    /user/request             → daftar request + form buat baru
POST   /user/request             → create request
GET    /user/riwayat             → riwayat transaksi
GET    /user/poin                → poin & reward
```

### Mitra (auth + role:mitra)

```
GET    /mitra/dashboard                  → main dashboard
GET    /mitra/tugas                      → daftar tugas tersedia
POST   /mitra/ambil/{ewasteRequest}     → ambil order
PUT    /mitra/status/{ewasteRequest}    → update status
GET    /mitra/riwayat                    → riwayat pengambilan
GET    /mitra/scan                       → scan QR code
```

### Admin (auth + role:admin)

```
GET    /admin/dashboard                      → admin panel
GET    /admin/transaksi                      → semua transaksi
GET    /admin/pengguna                       → kelola pengguna
PUT    /admin/pengguna/{user}/approve       → approve mitra
DELETE /admin/pengguna/{user}/reject        → reject mitra
GET    /admin/laporan                        → laporan transaksi
GET    /admin/pengaturan                     → pengaturan sistem
POST   /admin/category                       → create category
PUT    /admin/category/{category}            → update category
DELETE /admin/category/{category}            → delete category
```

---

## 🔐 Role & Permission

### Admin
- Full access ke semua fitur
- Approve/reject mitra baru
- CRUD kategori e-waste
- Lihat semua transaksi & laporan

### Mitra
- **Harus di-approve admin** sebelum bisa login
- Ambil tugas dari request yang menunggu
- Update status order
- Kontak kontributor via WhatsApp

### Masyarakat (Kontributor)
- **Langsung approved** saat registrasi
- Buat request penjemputan e-waste
- Lihat riwayat & poin reward
- Tidak bisa akses halaman mitra/admin

---

## 🔧 Troubleshooting

### Error: "SQLSTATE[HY000] [1049] Unknown database"
- Buat database manual di phpMyAdmin/MySQL
- Atau jalankan: `CREATE DATABASE uas_web;`

### Error: "Base table or view not found"
- Jalankan migration: `php artisan migrate`
- Atau reset: `php artisan migrate:fresh --seed`

### Mitra tidak bisa login
- Pastikan mitra sudah di-approve oleh admin
- Cek kolom `is_approved` di tabel `users`

### Assets tidak muncul
- Jalankan `npm run build`
- Atau `npm run dev` untuk development

### Kategori tidak muncul di dropdown
- Pastikan sudah jalankan seeder: `php artisan db:seed`
- Atau tambah manual via halaman pengaturan admin

---

## 📚 Dokumentasi Tambahan

- [Laravel 11 Docs](https://laravel.com/docs/11.x)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Blade Templates](https://laravel.com/docs/11.x/blade)

---

## 📄 License

MIT License - Open source untuk keperluan edukasi.

---

## 👨‍💻 Author

**Kelompok 4 - UAS Pemrograman Web**  
Built with Laravel 11 + Tailwind CSS

---

**Made with ♻️ by E-Waste Hub Team**
