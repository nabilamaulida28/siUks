# Deploy SIUKS (Laravel 11) ke Vercel + Aiven

## File yang ditambah / diganti di project
| File | Keterangan |
|---|---|
| `vercel.json` | BARU. Runtime PHP (vercel-php) + semua request ke `api/index.php` |
| `api/index.php` | BARU. Entry point; pakai /tmp untuk storage & cache, tulis CA Aiven |
| `.vercelignore` | BARU. Jangan upload .env, vendor, log, cache lama |
| `app/Providers/AppServiceProvider.php` | GANTI. Paksa https di production |
| `bootstrap/app.php` | GANTI. Tambah `trustProxies(at: '*')` |
| `config/database.php` | GANTI. `sslmode` PostgreSQL bisa diatur lewat `DB_SSLMODE` |
| `.env.vercel.example` | Daftar env var yang diisi di Vercel Dashboard (bukan untuk di-commit berisi rahasia) |

## Langkah singkat
1. Salin file di atas ke root project (timpa yang lama).
2. Buat service database di Aiven, catat Host, Port, User, Password, dan unduh CA certificate (MySQL).
3. Dari komputer lokal, isi `.env` lokal dengan kredensial Aiven lalu jalankan:
   `php artisan migrate --seed --force`
4. Push project ke GitHub (pastikan `.env` tidak ikut).
5. Vercel > Add New Project > import repo > isi Environment Variables (lihat `.env.vercel.example`) > Deploy.
6. Buka URL Vercel, login dengan akun seeder, LALU GANTI password default.
