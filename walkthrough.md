# 🗄️ Database & Auth — Panduan Belajar UAS-web

> Aplikasi ini adalah platform **E-Waste (sampah elektronik)** berbasis Laravel.  
> Ada 3 peran pengguna: **Masyarakat** (kontributor sampah), **Mitra** (pengepul/lapak), dan **Admin**.

---

## 📐 Gambaran Arsitektur Besar

```
Browser
  │
  ▼
routes/web.php          ← Pintu masuk semua request HTTP
  │
  ├── Middleware: auth   ← Cek: apakah user sudah login?
  │     └── Middleware: role:xxx  ← Cek: apakah role-nya sesuai?
  │
  ▼
Controller (AuthController / DashboardController)
  │
  ▼
Model (User / EwasteRequest / Category)  ← Bicara dengan database
  │
  ▼
Database (MySQL via Migration + Seeder)
```

---

## 1️⃣ MIGRATIONS — Cetak Biru Tabel Database

> **Analoginya:** Migration = arsitek yang menggambar denah bangunan (tabel).  
> Jalankan dengan: `php artisan migrate`

### 📁 Urutan Eksekusi (berdasarkan nama file / timestamp)

```
0001_01_01_000000  →  create_users_table
0001_01_01_000001  →  create_cache_table
0001_01_01_000002  →  create_jobs_table
2026_05_16_000001  →  create_ewaste_requests_table
2026_05_16_042113  →  create_categories_table
2026_05_16_043837  →  update_ewaste_requests_table_add_category_id  ← ALTER TABLE
2026_05_22_062024  →  create_agent_conversations_table
```

> ⚠️ **Angka di depan nama file adalah timestamp** — Laravel menjalankan migrasi dari yang terlama ke terbaru. Urutan ini **PENTING** untuk foreign key!

---

### 🔑 Tabel `users`

```php
// file: 0001_01_01_000000_create_users_table.php
Schema::create('users', function (Blueprint $table) {
    $table->id();                                              // PK auto-increment
    $table->string('name');
    $table->string('email')->unique();                        // tidak boleh duplikat
    $table->string('phone')->nullable();
    $table->enum('role', ['masyarakat', 'mitra', 'admin'])
          ->default('masyarakat');                            // role default
    $table->string('nama_lapak')->nullable();                 // khusus mitra
    $table->string('alamat_lapak')->nullable();               // khusus mitra
    $table->boolean('is_approved')->default(true);            // mitra perlu approval
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();                                  // untuk "ingat saya"
    $table->timestamps();                                     // created_at, updated_at
});
```

**Kolom penting:**
| Kolom | Tipe | Keterangan |
|---|---|---|
| `role` | enum | `masyarakat` / `mitra` / `admin` |
| `is_approved` | boolean | Khusus mitra — harus disetujui admin dulu |
| `nama_lapak` | string | Hanya diisi oleh mitra |
| `remember_token` | string | Auto-dikelola Laravel untuk fitur "Remember Me" |

---

### 📦 Tabel `ewaste_requests`

```php
// file: 2026_05_16_000001_create_ewaste_requests_table.php
Schema::create('ewaste_requests', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    //  └─ FK ke users.id, jika user dihapus → request ikut terhapus

    $table->foreignId('mitra_id')->nullable()->constrained('users')->onDelete('set null');
    //  └─ FK ke users.id, jika mitra dihapus → di-set NULL (tidak cascade)

    $table->string('kategori');                               // string lama (diganti category_id)
    $table->decimal('berat', 8, 2);                          // contoh: 9999999.99 kg
    $table->text('alamat');
    $table->text('catatan')->nullable();
    $table->string('foto')->nullable();                       // path file foto
    $table->enum('status', ['menunggu','diambil','diproses','selesai','dibatalkan'])
          ->default('menunggu');
    $table->timestamps();
});
```

**Alur Status:**
```
menunggu → diambil → diproses → selesai
    └─────────────────────────→ dibatalkan
```

---

### 🔄 Migration ALTER TABLE (menambah kolom)

```php
// file: 2026_05_16_043837_update_ewaste_requests_table_add_category_id.php
Schema::table('ewaste_requests', function (Blueprint $table) {
    // Tambah kolom baru — pakai ->after() agar urutannya rapi
    $table->foreignId('category_id')
          ->nullable()
          ->after('user_id')           // ← letakkan setelah kolom user_id
          ->constrained()              // ← FK ke tabel 'categories'
          ->onDelete('set null');

    // Ubah kolom yang sudah ada menjadi nullable
    $table->string('kategori')->nullable()->change();  // ← pakai ->change()
});
```

> 💡 **`Schema::table`** (bukan `Schema::create`) dipakai untuk **mengubah tabel yang sudah ada**.  
> `->change()` di akhir artinya "ubah kolom ini, bukan buat baru".

---

## 2️⃣ MODELS — Jembatan PHP ke Database

> **Analoginya:** Model = pegawai yang tahu cara baca/tulis data ke tabel tertentu.  
> Setiap model mewakili satu tabel.

### 🧑 Model `User`

```php
// app/Models/User.php
class User extends Authenticatable   // ← bukan 'extends Model' biasa!
{
    use HasFactory, Notifiable;

    // Kolom yang BOLEH diisi via User::create() atau $user->fill()
    protected $fillable = [
        'name', 'email', 'password', 'phone',
        'role', 'nama_lapak', 'alamat_lapak', 'is_approved',
    ];

    // Kolom yang DISEMBUNYIKAN dari JSON/array output
    protected $hidden = ['password', 'remember_token'];

    // Auto-casting tipe data
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',  // string → Carbon object
            'password'          => 'hashed',    // otomatis di-hash saat diisi
            'is_approved'       => 'boolean',   // "1"/"0" → true/false
        ];
    }
}
```

> 💡 **`Authenticatable`** memberi kemampuan login (`Auth::attempt()`, `Auth::user()`, dll).  
> Kalau bukan model user, cukup `extends Model`.

**Relasi di User:**
```php
// Satu User (masyarakat) punya BANYAK ewaste_requests
public function ewasteRequests(): HasMany
{
    return $this->hasMany(EwasteRequest::class, 'user_id');
    //                    ^ Model target        ^ FK di tabel ewaste_requests
}

// Satu User (mitra) menangani BANYAK request
public function handledRequests(): HasMany
{
    return $this->hasMany(EwasteRequest::class, 'mitra_id');
    //                                          ^ FK berbeda!
}
```

---

### ♻️ Model `EwasteRequest`

```php
// app/Models/EwasteRequest.php
class EwasteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'mitra_id', 'category_id',
        'kategori', 'berat', 'alamat', 'catatan', 'foto', 'status',
    ];

    // Request ini milik siapa? (BelongsTo = "dimiliki oleh")
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Siapa mitranya?
    public function mitra(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mitra_id');
        //           ^ Model sama (User), tapi FK berbeda!
    }

    // Kategori e-waste-nya apa?
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
        // FK otomatis: 'category_id' (nama model + _id)
    }
}
```

**Peta Relasi Lengkap:**
```
users ──────────────────┐ (user_id)
                        ▼
                 ewaste_requests ──── categories
                        ▲
users ──────────────────┘ (mitra_id)
```

---

### 📂 Model `Category`

```php
class Category extends Model
{
    protected $fillable = ['name'];

    // Satu Category punya banyak EwasteRequest
    public function ewasteRequests()
    {
        return $this->hasMany(EwasteRequest::class);
    }
}
```

---

### 🔗 Ringkasan Relasi Eloquent

| Method | Arah | Contoh |
|---|---|---|
| `hasMany()` | Satu → Banyak | User punya banyak EwasteRequest |
| `belongsTo()` | Banyak → Satu | EwasteRequest dimiliki satu User |
| `hasOne()` | Satu → Satu | User punya satu Profile |
| `belongsToMany()` | Banyak ↔ Banyak | User punya banyak Role |

---

## 3️⃣ SEEDERS — Data Awal Database

> **Analoginya:** Seeder = tim yang mengisi furnitur ke dalam gedung yang baru dibangun.  
> Jalankan dengan: `php artisan db:seed`

```php
// database/seeders/DatabaseSeeder.php
public function run(): void
{
    // 1. Isi tabel categories
    $categories = ['Laptop & Komputer', 'Smartphone', 'TV & Monitor', ...];
    foreach ($categories as $categoryName) {
        Category::create(['name' => $categoryName]);
        //       ^ Gunakan firstOrCreate() jika tidak mau duplikat!
    }

    // 2. Buat user Admin
    User::factory()->create([
        'name'        => 'Admin',
        'email'       => 'admin@example.com',
        'role'        => 'admin',
        'is_approved' => true,
        'password'    => bcrypt('112233'),
        //               ^ Enkripsi password secara manual di seeder
    ]);

    // 3. Buat user Masyarakat
    User::factory()->create([...]);

    // 4. Buat user Mitra
    User::factory()->create([
        'nama_lapak'   => 'Lapak Mitra',
        'alamat_lapak' => 'Jl. Contoh No. 123',
        ...
    ]);
}
```

**Akun default setelah seeder:**
| Email | Password | Role |
|---|---|---|
| `admin@example.com` | `112233` | admin |
| `kontributor@example.com` | `112233` | masyarakat |
| `mitra@example.com` | `112233` | mitra |

> 💡 **`User::factory()->create()`** = pakai Factory (template random) tapi **timpa** dengan data spesifik.  
> Kalau mau reset + isi ulang: `php artisan migrate:fresh --seed`

---

## 4️⃣ AUTH CONTROLLER — Logika Login & Register

```php
// app/Http/Controllers/AuthController.php
class AuthController extends Controller
{
    // GET /register → tampilkan halaman form register
    public function register() { return view('auth.register'); }

    // GET /login → tampilkan halaman form login
    public function login()    { return view('auth.login'); }
```

### ✍️ Method `store()` — Proses Register

```php
public function store(Request $request)
{
    // 1. VALIDASI INPUT
    $validated = $request->validate([
        'name'             => 'required',
        'email'            => 'required|email|unique:users',  // cek duplikat di DB
        'role'             => 'required|in:masyarakat,mitra', // hanya 2 pilihan
        'password'         => 'required|min:6',
        'confirm_password' => 'required|same:password',       // harus cocok
        // nullable = boleh kosong
        'phone'       => 'nullable|string',
        'nama_lapak'  => 'nullable|string',
        'alamat_lapak'=> 'nullable|string',
    ]);

    // 2. SIMPAN KE DATABASE
    User::create([
        ...
        // Logika bisnis: mitra butuh approval, masyarakat langsung bisa login
        'is_approved' => $validated['role'] === 'masyarakat',
        //                ↑ true jika masyarakat, false jika mitra
        'password'    => Hash::make($validated['password']),  // enkripsi!
    ]);

    // 3. REDIRECT dengan pesan sukses
    $message = $validated['role'] === 'mitra'
        ? 'Akun Mitra menunggu persetujuan admin.'
        : 'Pendaftaran berhasil! Silakan masuk.';

    return redirect()->route('auth.login')->with('success', $message);
}
```

---

### 🔐 Method `authenticate()` — Proses Login

```php
public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // Auth::attempt() = cek email+password, buat session jika cocok
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate(); // ← cegah Session Fixation Attack!

        $user = Auth::user();

        // GUARD KHUSUS: Mitra belum approved? Paksa logout!
        if ($user->role === 'mitra' && !$user->is_approved) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun Mitra Anda belum disetujui admin.',
            ])->onlyInput('email');
        }

        // Redirect berdasarkan role (PHP 8 match expression)
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'mitra' => redirect()->route('mitra.dashboard'),
            default => redirect()->route('user.dashboard'),
        };
    }

    // Login gagal
    return back()->withErrors([
        'email' => 'Email atau kata sandi tidak sesuai.',
    ])->onlyInput('email');
}
```

**Alur Login:**
```
POST /login
  │
  ├─ Validasi input
  ├─ Auth::attempt() ──── GAGAL → kembali ke form + error
  │       │
  │      BERHASIL
  │       │
  ├─ Cek: mitra belum approved? → logout + error
  │
  └─ match(role):
       admin   → /admin/dashboard
       mitra   → /mitra/dashboard
       default → /user/dashboard
```

---

### 🚪 Method `logout()`

```php
public function logout(Request $request)
{
    Auth::logout();                         // hapus session auth
    $request->session()->invalidate();      // hapus semua data session
    $request->session()->regenerateToken(); // buat CSRF token baru
    return redirect('/');
}
```

> ⚠️ **Tiga langkah logout** ini penting untuk keamanan — jangan hilangkan salah satunya!

---

## 5️⃣ MIDDLEWARE — Penjaga Pintu

> **Analoginya:** Middleware = satpam yang memeriksa kartu identitas sebelum mengizinkan masuk.

### 🛡️ `RoleMiddleware`

```php
// app/Http/Middleware/RoleMiddleware.php
public function handle(Request $request, Closure $next, string ...$roles): Response
{
    //                                                   ↑ bisa terima banyak role
    $user = Auth::user();

    // Apakah role user termasuk dalam daftar yang diizinkan?
    if (!in_array($user->role, $roles)) {
        // Tidak diizinkan → redirect ke dashboard yang sesuai rolenya
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'mitra' => redirect()->route('mitra.dashboard'),
            default => redirect()->route('user.dashboard'),
        };
    }

    // Lolos pemeriksaan → lanjutkan request
    return $next($request);
}
```

**Cara pakai di routes:**
```php
// web.php
Route::middleware('role:masyarakat')->group(function () {
    // Hanya role 'masyarakat' yang bisa akses
});

// Boleh lebih dari satu role:
Route::middleware('role:admin,mitra')->group(...)
//                       ↑        ↑
//              string ...$roles menerima keduanya
```

### 🔗 Registrasi Middleware di `bootstrap/app.php`

```php
// Middleware harus didaftarkan dengan alias agar bisa dipakai via 'role:xxx'
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

### 🔐 Middleware `auth` (bawaan Laravel)

```php
Route::middleware('auth')->group(function () {
    // Jika belum login → redirect ke /login otomatis
});
```

**Stack Middleware per Request:**
```
Request masuk
  │
  ▼ middleware: auth        ← cek: sudah login?
  │   TIDAK → redirect /login
  │
  ▼ middleware: role:mitra  ← cek: role-nya mitra?
  │   TIDAK → redirect ke dashboard role aslinya
  │
  ▼ Controller::method()   ← eksekusi logika
  │
  ▼ Response keluar
```

---

## 6️⃣ CONFIG — Konfigurasi Auth

```php
// config/auth.php

// Guard default: 'web' (session-based)
'defaults' => ['guard' => 'web', 'passwords' => 'users'],

// Guard 'web' menggunakan session + provider 'users'
'guards' => [
    'web' => [
        'driver'   => 'session',   // simpan state login di session
        'provider' => 'users',
    ],
],

// Provider 'users' → gunakan Eloquent dengan model User
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model'  => User::class,   // ← Auth::user() akan return instance ini
    ],
],

// Token reset password expire setelah 60 menit
'passwords' => [
    'users' => ['expire' => 60, 'throttle' => 60],
],
```

**Cara kerja config ini:**

```
Auth::attempt(['email'=>..., 'password'=>...])
  │
  ├─ Guard 'web' (session driver)
  │      └─ cari user via Provider 'users'
  │              └─ Eloquent query: User::where('email', ...)->first()
  │                     └─ Hash::check(password, user->password)
  │
  ├─ COCOK → simpan user_id di session
  └─ Auth::user() → return User Eloquent object
```

---

## 🗺️ Peta Lengkap: Dari Request ke Response

```
Browser POST /login
  │
  ▼
routes/web.php → Route::post('/login', [AuthController::class, 'authenticate'])
  │
  ▼
AuthController::authenticate()
  ├─ $request->validate([...])          ← validasi
  ├─ Auth::attempt($credentials)        ← cek ke DB via config/auth.php
  │     └─ Provider 'users' (Eloquent)
  │           └─ SELECT * FROM users WHERE email = ? (1 query)
  │                 └─ Hash::check(password)
  ├─ session()->regenerate()
  ├─ cek is_approved (business logic)
  └─ match($user->role) → redirect
```

---

## ⚡ Cheat Sheet Perintah Artisan

```bash
# Jalankan semua migration
php artisan migrate

# Reset + ulang migration (HAPUS SEMUA DATA!)
php artisan migrate:fresh

# Reset + ulang + isi seeder sekaligus
php artisan migrate:fresh --seed

# Isi seeder saja (tanpa reset migration)
php artisan db:seed

# Lihat status semua migration
php artisan migrate:status

# Buat migration baru
php artisan make:migration create_nama_tabel_table

# Buat model + migration sekaligus
php artisan make:model NamaModel -m

# Buat model + migration + seeder + factory sekaligus
php artisan make:model NamaModel -mfs
```

---

## 🔑 Konsep Kunci yang Perlu Diingat

| Konsep | Di mana | Fungsi |
|---|---|---|
| `$fillable` | Model | Whitelist kolom untuk mass assignment |
| `$hidden` | Model | Sembunyikan kolom dari JSON output |
| `casts()` | Model | Auto-convert tipe data |
| `foreignId()->constrained()` | Migration | Buat FK + index otomatis |
| `->nullable()->change()` | Migration | Ubah kolom existing |
| `Auth::attempt()` | Controller | Login + buat session |
| `Auth::user()` | Di mana saja | Ambil user yang sedang login |
| `Hash::make()` | Controller | Enkripsi password |
| `$next($request)` | Middleware | Lanjutkan ke handler berikutnya |
| `string ...$roles` | Middleware | Variadic parameter (banyak argumen) |
