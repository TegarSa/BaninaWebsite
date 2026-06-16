# 👘 BANINA - Website Toko Busana Muslim Pria (Laravel Version)

Website katalog busana muslim pria dinamis dengan panel admin lengkap, kini dimigrasikan menggunakan framework Laravel.

**Tema:** Hitam + Emas (Premium) 🖤✨ | *Men Wear Since 2019*

---

## 📁 Struktur Folder Utama

```text
banina-laravel/
├── app/
│   ├── Http/Controllers/Frontend/
│   │   ├── HomeController.php       ← Mengelola Beranda, Tentang, & Kontak
│   │   └── ProductController.php    ← Mengelola Katalog & Detail Produk (Clean URL)
│   └── Models/                      ← Eloquent Models (Product, Category, Banner, Setting)
├── bootstrap/
├── config/                          ← File konfigurasi Laravel
├── database/
│   └── migrations/                  ← Migrasi skema database
├── public/                          ← Root web server publik
│   ├── assets/
│   │   ├── css/style.css            ← Stylesheet utama (tema hitam + emas)
│   │   └── js/main.js               ← JavaScript frontend
│   └── uploads/                     ← Folder penyimpanan upload gambar produk & banner
├── resources/
│   └── views/                       ← Blade Templating Engine
│       └── frontend/
│           ├── layouts/app.blade.php ← Layout master (Header & Footer)
│           └── pages/
│               ├── home.blade.php           ← Halaman beranda
│               ├── catalog.blade.php        ← Halaman katalog + filter & pencarian
│               ├── product_detail.blade.php ← Halaman detail produk (Multi-image)
│               ├── about.blade.php          ← Halaman tentang kami
│               └── contact.blade.php        ← Halaman kontak dengan data dinamis
├── routes/
│   └── web.php                      ← Berisi routing aplikasi & Clean URLs
└── .env                             ← Konfigurasi environment (Database, URL, dll)

⚙️ Cara Instalasi & Setup lokal

1. Prasyarat Sistem
- PHP 8.2+
- Composer
- MySQL 8.0+ / MariaDB
- Web Server (Apache/Nginx/Laragon)

2. Kloning dan Instalasi Dependensi
Masuk ke direktori project, lalu jalankan composer untuk menginstal semua library:

```bash
composer install

```

### 3. Konfigurasi Environment (`.env`)

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env

```

Buka file `.env` dan sesuaikan kredensial database Anda:

```env
APP_NAME=BANINA
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=banina_store
DB_USERNAME=root
DB_PASSWORD=

```

Generate application key baru:

```bash
php artisan key:generate

```

### 4. Setup Database & Penyimpanan

Jalankan migrasi database beserta data awal (seeder) jika ada:

```bash
php artisan migrate --seed

```

Hubungkan folder penyimpanan file upload agar bisa diakses secara publik:

```bash
php artisan storage:link

```

### 5. Jalankan Server Lokal

```bash
php artisan serve

```

Website sekarang dapat diakses melalui browser di alamat `http://127.0.0.1:8000`.

---

## 🔗 Struktur URL Baru (Clean URLs)

Sistem navigasi telah diubah dari berkstensi `.php` native menjadi route berbasis nama (Named Routes) di Laravel:

| Halaman | URL Native (Lama) | URL Laravel (Baru) | Nama Route |
| --- | --- | --- | --- |
| **Beranda** | `/index.php` | `/` | `route('home')` |
| **Katalog Semua** | `/pages/catalog.php` | `/products` | `route('catalog')` |
| **Katalog Kategori** | `/pages/catalog.php?category=slug` | `/products/{category_slug}` | `route('catalog', $slug)` |
| **Detail Produk** | `/pages/product.php?slug=slug` | `/product/{slug}` | `route('product.show', $slug)` |
| **Tentang Kami** | `/pages/about.php` | `/about` | `route('about')` |
| **Kontak Kami** | `/pages/contact.php` | `/contact` | `route('contact')` |

---

## 🔐 Login Admin Default

*(Bagian ini akan disesuaikan setelah proses penulisan ulang Dashboard Admin Laravel selesai)*

|  |  |
| --- | --- |
| **Username / Email** | `admin@banina.com` |
| **Password** | `admin123` |

---

## ✨ Fitur Utama (Laravel Version)

### Halaman Publik

* 🏠 **Beranda Dinamis** — Banner slider, grid kategori otomatis dengan counter jumlah produk, produk unggulan, dan integrasi WhatsApp.
* 📋 **Katalog Terfilter** — Filter produk instan berdasarkan kategori via *Clean Parameter URL* serta fitur pencarian kata kunci bertenaga Eloquent Query.
* 🔍 **Detail Produk Advance** — Menampilkan galeri gambar multi-foto (Primary image swap), deskripsi dengan auto-line-break (`nl2br`), deteksi rentang harga produk dinamis, tombol *Direct Order via Shopee*, dan rekomendasi 4 produk terkait acak (*Random Related Products*).
* 📖 **Tentang Kami & Kontak** — Penarikan informasi dinamis langsung dari tabel `settings` database (No hardcoded data).

### Panel Admin

*(Sedang dalam proses migrasi ke arsitektur Controller & Blade)*

---

## 🛠️ Tech Stack

* **Backend**: Laravel 12.x / 10.x (Framework PHP MVC)
* **Database**: MySQL dengan Eloquent ORM & Query Builder
* **Frontend**: HTML5, CSS3 (Custom Variables), Vanilla JS
* **Template Engine**: Laravel Blade Components
* **Icons & Fonts**: Font Awesome 6, Playfair Display, Cormorant Garamond, DM Sans