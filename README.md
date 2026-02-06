# Sistem Informasi Laboratorium – Wilmar Nabati Indonesia

Aplikasi untuk mengelola data laboratorium: Instrument/Glassware, Jenis Produk, SOP Pengujian, dan Dokumen Laporan. Mendukung upload gambar ke Supabase Storage (S3-compatible) agar data aman saat di-deploy.

## Fitur
- Manajemen Instrument & Glassware
- Manajemen Jenis Produk beserta gambar
- Tabel SOP Pengujian
- Dokumen Laporan
- Upload gambar ke Supabase Storage (disk `public`)

## Teknologi
- Laravel 10, PHP 8.1+
- Supabase (Postgres, Storage S3-compatible)
- TailwindCSS, Alpine.js

## Instalasi Lokal
1. Install dependencies:
   ```bash
   composer install
   ```
2. Duplikasi `.env.example` menjadi `.env` dan isi variabel yang diperlukan (database lokal, dll).
3. Generate key:
   ```bash
   php artisan key:generate
   ```
4. Migrasi & seed:
   ```bash
   php artisan migrate --seed
   ```
5. Jalankan:
   ```bash
   php artisan serve
   ```
   Akses `http://localhost:8000`.

## Konfigurasi Storage (Supabase)
Set variabel berikut (di `.env` atau Environment Variables platform deploy):
- `FILESYSTEM_DISK=supabase`
- `AWS_ACCESS_KEY_ID` (dari Supabase → Storage → S3 Access Keys)
- `AWS_SECRET_ACCESS_KEY` (dari Supabase → Storage → S3 Access Keys)
- `AWS_DEFAULT_REGION=ap-southeast-1`
- `AWS_BUCKET=uploads` (bucket publik bernama `uploads`)
- `AWS_ENDPOINT=https://<PROJECT_REF>.supabase.co/storage/v1/s3`
- `AWS_USE_PATH_STYLE_ENDPOINT=true`
- `AWS_URL=https://<PROJECT_REF>.supabase.co/storage/v1/object/public/uploads`

Pastikan bucket `uploads` bersifat Public. Aplikasi akan merender gambar menggunakan `Storage::disk('public')->url($path)`.

## Deployment (mis. Vercel)
Isi Environment Variables sesuai bagian “Konfigurasi Storage (Supabase)” dan variabel aplikasi (`APP_ENV`, `APP_URL`, `APP_KEY`, dsb). Setelah deploy berhasil, aplikasi langsung menggunakan Supabase untuk upload & akses gambar.

## Akses & Otentikasi
- Aplikasi mendukung otentikasi admin untuk pengelolaan data.
- Kredensial tidak dipublikasikan di README atau repository.
- Gunakan seeder/fitur admin sesuai kebutuhan internal dan simpan rahasia di `.env` (atau Environment Variables platform deploy).

## Keamanan & Rahasia (.env)
- Jangan commit `.env`. Sudah di-ignore melalui `.gitignore`.
- Jika `.env` terlanjur ter-publish di GitHub:
  1) Putuskan/rotasi semua kredensial (DB, Supabase Access Keys).
  2) Hapus file dari history repository menggunakan `git filter-repo` atau BFG:
     - `git filter-repo --path .env --invert-paths`
     - `git push origin --force`
  3) Buat repository sementara Private hingga semua kredensial diganti.
  4) Pastikan `.env` tidak ada di commit terbaru dan semua fork/clone lama dianggap tidak aman.

## Troubleshooting
- Vite manifest error: jalankan `npm install && npm run build` (atau pastikan `public/build` tersedia).
- Gambar tidak muncul: cek konfigurasi Supabase dan endpoint; uji di `/check-storage` jika perlu.
