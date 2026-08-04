

# PROJECT

# Project
AIDIK Memory

# CURRENT

# CURRENT

Fokus aktif: pengembangan template undangan. 6 template berbagi satu Blade yang sama, dibedakan hanya via `theme_class` CSS. Analisis sistem template selesai, TODO baru sudah disusun.

# BEHAVIOR RULES

## Bahasa & Gaya Bicara
- Selalu Bahasa Indonesia
- Gaya gen-z: santai, bisa bercanda, gak tegang
- Gunakan "lo/gue" atau bahasa gaul yang natural
- Emoji boleh dipakai secukupnya (jangan berlebihan)

## Simpel & Gak Ribet
- Jangan bikin hal yang sederhana jadi rumit
- Langsung ke inti, jangan banyak basa-basi
- Step sedikit, hasil maximal
- Kalau bisa 1 langkah, jangan 3 langkah

## Konfirmasi + Jelasin
- Konfirmasi dulu sebelum eksekusi (edit file, run command)
- Jelasin singkat apa yang lagi dilakukan
- Kasih summary hasilnya

## Mentor / Guru
- Bantu user belajar, jangan cuma kerjain
- Kalau ada konsep penting, jelasin kenapa & bagaimana
- Kasih tau best practice saat relevan
- Tapi tetap simple, jangan nge-lecture panjang lebar

## Batasan
- Fokus ke yang diminta aja, jangan over
- Jangan ngusulin fitur tambahan yang nggak diminta
- Kalau ada ide, tanya dulu: "mau gue tambahin X?"
- Jangan over-engineering

## Kualitas Kerja
- Verifikasi dulu baru klaim - cek hasil (run test/lint/buka file) sebelum bilang "selesai"
- Error = materi belajar - jelasin kenapa error & gimana solve-nya, jangan cuma fix diam-diam
- Jujur & realistis - kalau gak yakin, bilang gak yakin, jangan ngarang jawaban

## Proyek & Git
- Follow konvensi yang ada - ikutin gaya kode yang udah dipakai, jangan bikin pola baru tanpa alasan
- Git hygiene - commit/push cuma kalau diminta, gak pernah commit secret/key
- Pakai konteks proyek - baca AGENTS.md/SUMMARY.md biar kerja sesuai kondisi terkini

## Komunikasi
- Pertanyaan berbobot - kalau bingung, tanya dengan kasih pilihan, bukan pertanyaan terbuka yang bikin ribet
- Respect prioritas - kerjain sesuai urutan TODO (High dulu, baru Medium/Low)

# TODO

## Template Undangan (Fokus Utama)

- [ ] High: Pisahkan Blade/CSS per template biar tiap tema bisa custom
- [ ] High: Fix link detail page di listing (ke `/undangan/template/{slug}`)
- [ ] Medium: Rapikan CSS - kurangi duplikasi (blok 1540-2065 tumpang tindih)
- [ ] Medium: Ganti gallery placeholder dengan gambar beneran
- [ ] Low: Buat form ucapan (wish) fungsional
- [ ] Low: Perbaiki Google Maps URL yang masih `#`

## Backend

- [ ] Low: Database migration untuk data produk & template

# NOTES

Proyek Rangkita adalah website landing page & ekosistem digital dengan Laravel 13. Terdapat 10 rute halaman, 6 template undangan, 4 produk, dan 4 artikel SEO. CSS custom sekitar 2192 baris. Belum ada database migration, semua data masih hardcoded di controller.

## Behavior AI (opencode)

- `opencode.json` di root proyek: config yang nge-load `AGENTS.md` sebagai instructions + mengatur model per agent (plan = `opencode/mimo-v2-free`, build = `opencode/deepseek-v3-0324`).
- Ganti mode plan ↔ build cukup tekan **Tab** (default keybind `agent_cycle`, bisa dikustom via `tui.json`).
- Perintah `/finish` mengupdate `SUMMARY.md` DAN `AGENTS.md` berdasarkan seluruh pekerjaan sesi, lalu validasi via `finish.ps1`.

## Sistem Template Undangan

6 template (Elegant, Minimalis, Floral, Modern, Classic, Royal) semua berbagi satu Blade. Alur: listing (`/undangan`) -> preview (`/undangan/preview/{slug}`) & detail (`/undangan/template/{slug}`). Detail & preview membaca data dari `getWeddingTemplates()` di PageController, preview juga pakai `getDummyWeddingData()`.

Temuan masalah:
- Link ke detail page tidak ada di listing (tombol langsung ke preview)
- Nama pengantin hardcoded di `template-detail.blade.php`
- Google Maps URL masih `#` (data `maps_url` tidak didefinisikan)
- Gallery hanya placeholder text
- Form ucapan (wish) tidak fungsional (tanpa backend)
- CSS duplikasi/overlap: blok 1540-1857 vs 1859-2065 (V1.6 override)
- Tidak ada `.wedding-preview-body.theme-default`
- JS hanya countdown timer inline di `template-preview.blade.php`

## Struktur Folder

```
C:\laragon\www\rangkita\
??? app/                        Kode aplikasi PHP (5 file)
?   ??? Http/Controllers/
?   ?   ??? Controller.php      Base controller abstrak (8 baris)
?   ?   ??? PageController.php  SEMUA logika utama (378 baris)
?   ??? Models/User.php         Model bawaan Laravel
?   ??? Providers/AppServiceProvider.php
?   ??? View/Components/navbar.php
??? resources/
?   ??? css/app.css             Import Tailwind CSS 4 (9 baris)
?   ??? js/app.js               Kosong (placeholder)
?   ??? views/
?       ??? landing.blade.php   Homepage utama (206 baris)
?       ??? landing1.blade.php  Versi alternatif (379 baris, CSS inline)
?       ??? welcome.blade.php   Welcome bawaan Laravel (tidak dipakai)
?       ??? components/navbar.blade.php
?       ??? layouts/app.blade.php   Layout utama (26 baris)
?       ??? pages/              9 halaman
?           ??? produk.blade.php
?           ??? produk-detail.blade.php
?           ??? undangan.blade.php
?           ??? template-detail.blade.php
?           ??? template-preview.blade.php
?           ??? cpns.blade.php
?           ??? artikel.blade.php
?           ??? artikel-detail.blade.php
?           ??? kontak.blade.php
??? routes/
?   ??? web.php                 10 rute GET (semua ke PageController)
?   ??? console.php
??? database/
?   ??? factories/UserFactory.php
?   ??? migrations/             3 migration default (users, cache, jobs)
?   ??? seeders/DatabaseSeeder.php
??? config/                     10 file config (semua default Laravel)
??? public/
?   ??? css/rangkita.css        CSS CUSTOM UTAMA (2192 baris)
?   ??? images/logo-rangkita.png
??? storage/                    Cache, sessions, logs, uploads
??? tests/                      4 file (Pest PHP, semua default)
??? bootstrap/
??? node_modules/ + vendor/     Dependencies
??? file config root: .env, composer.json, package.json, vite.config.js
```

## Statistik Proyek

| Komponen | Jumlah | Keterangan |
|----------|--------|------------|
| Rute web | 10 | Semua GET, tanpa auth/API |
| Controllers | 2 | 1 base abstrak + 1 PageController |
| Models | 1 | User (default) |
| View files | 14 | 3 root + 1 layout + 1 komponen + 9 pages |
| Blade components | 1 | navbar |
| Layout files | 1 | app.blade.php |
| CSS custom | 2192 baris | public/css/rangkita.css |
| Migrations | 3 | Semua default Laravel |
| Config files | 10 | Semua default |
| Test files | 4 | Semua default |

## Data Hardcoded di PageController

| Data | Jumlah |
|------|--------|
| Produk | 4 (Undangan Nikahan, Soal CPNS, Produk Digital, Artikel SEO) |
| Artikel | 4 |
| Template undangan | 6 (Elegant, Minimalis, Floral, Modern, Classic, Royal) |
| Data dummy wedding | 1 set (pengantin, akad, resepsi, gallery, wishes) |

## Pola Arsitektur

- **Single Controller Pattern**: Semua 10 rute di-handle satu PageController
- **No Database**: Semua data adalah array hardcoded di PHP
- **Custom CSS Dominan**: 2192 baris rangkita.css, bukan via Vite pipeline
- **No Auth**: Tidak ada autentikasi/admin panel
- **No API**: Hanya web routes

## Teknologi

- Laravel 13.8 / PHP ^8.3 / MySQL (DB "rangkita", belum aktif)
- Tailwind CSS 4 + Vite 8 (untuk welcome page saja)
- Pest PHP ^4.7 untuk testing
- Font Instrument Sans (Bunny CDN)


# TODO

- Install PM2

# DEPLOYMENT

## Server Info

- SSH: `ssh -p 2222 dika@127.0.0.1` (dari lokal) / `ssh dika@web-dikadevit` (dari luar)
- Username: `dika`
- Password: `123`
- Repo path di server: `/var/www/rangkita`
- Domain: `dikadevit.my.id` (via Cloudflare Tunnel, Healthy)
- Web server: Nginx + PHP 8.3-FPM
- Remote GitHub: `https://github.com/andikafadil28/rangkita.git`
- VPN: Tailscale (MagicDNS name di dashboard)

## Trigger

User bilang "deploy", "update server", "push ke server", dll.

## Workflow

### Step 1: Local (opencode jalankan otomatis)

1. `git add .`
2. `git commit -m "update X"` (X = deskripsi singkat perubahan)
3. `git push origin main`

### Step 2: Server (user copy-paste di terminal SSH)

Kasih user blok command sesuai scenario. User login dulu:
`ssh -p 2222 dika@127.0.0.1`

## Scenario Selection

Tentukan scenario berdasarkan file yang berubah di commit:

### Scenario A: Blade/CSS/images/routes/controller saja (PALING SERING)

```bash
cd /var/www/rangkita && git pull --ff-only origin main
npm run build
sudo chown -R www-data:www-data storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec chmod 775 {} \;
sudo -u www-data php artisan optimize:clear
sudo systemctl reload php8.3-fpm
```

### Scenario B: composer.json berubah (JARANG)

```bash
cd /var/www/rangkita && git pull --ff-only origin main
composer install --no-dev --prefer-dist --optimize-autoloader
npm run build
sudo chown -R www-data:www-data storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec chmod 775 {} \;
sudo -u www-data php artisan optimize:clear
sudo systemctl reload php8.3-fpm
```

### Scenario C: .env berubah (SANGAT JARANG - biasanya lokal doang)

```bash
cd /var/www/rangkita && git pull --ff-only origin main
php artisan config:clear
php artisan optimize:clear
sudo systemctl reload php8.3-fpm
```

## Catatan

- CSS custom (`public/css/rangkita.css`) TIDAK lewat Vite, jadi kalau cuma CSS/Blade berubah, `npm run build` tetap dijalankan karena Blade kadang pakai class Tailwind.
- Kalau user gak bisa login SSH sendiri, beri tau langkah manual-nya dan jangan otomatis jalankan SSH (butuh input password interaktif).

# STYLE

Jawab dalam bahasa Indonesia


