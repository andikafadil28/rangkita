# CURRENT

Fokus aktif: **Quiz CPNS + Midtrans Payment** — Auth System **SELESAI** (9/9 step). Bug Fixing **SELESAI** (18/18).

# TODO

## 1. Bug Fixing (18 issues) - Estimasi: ~1.5 jam

### Critical Bugs
- [x] **Bug #1**: Data wedding hardcode di template-detail → controller gak pass `$wedding`
  - File: `PageController.php:234` + `template-detail.blade.php`
  - Fix: Tambah `$wedding = $this->getDummyWeddingData();` di method `templateDetail()`, pass ke view
- [x] **Bug #2**: Link detail page gak ada di listing undangan
  - File: `undangan.blade.php:148-157`
  - Fix: Tambah tombol "Lihat Detail" ke `/undangan/template/{slug}`

### High Bugs
- [x] **Bug #3**: `<script>` di luar `</body>` (invalid HTML)
  - File: `template-preview.blade.php:201-360`
  - Fix: Pindah `</body>` ke sesudah script terakhir
- [x] **Bug #4**: Countdown script gak ada `DOMContentLoaded` wrapper
  - File: `template-preview.blade.php:203-241`
  - Fix: Wrap dalam `document.addEventListener('DOMContentLoaded', function() { ... });`

### Medium Bugs
- [ ] **Bug #5**: Missing `rel="noopener noreferrer"` di link external
   - File: `produk-detail.blade.php:48`
- [x] **Bug #6**: CSS target `button` tapi HTML pake `<a>`
  - File: `rangkita.css:1603` → ubah selector ke `.location-section button, .location-section a`
- [x] **Bug #7**: Hardcoded "Dika & Nur" di listing undangan
  - File: `undangan.blade.php:40-41`
- [x] **Bug #8**: Form inputs gak ada `name` attribute
  - File: `kontak.blade.php:112,117,132`
- [x] **Bug #9**: `APP_DEBUG=true` di .env → ubah ke `false`

### Low/Code Quality Bugs
- [x] **Bug #10**: Unused import `Request` di PageController (line 5)
- [x] **Bug #11**: WhatsApp number duplikat di 3 file → pindah ke config
- [x] **Bug #12**: Email & Instagram hardcoded di kontak
- [x] **Bug #13**: Unused files (welcome.blade.php, landing1.blade.php, app.js)
- [x] **Bug #14**: Font "Instrument Sans" di-Vite tapi gak dipake
- [x] **Bug #15**: Locale `en` tapi site Bahasa Indonesia → ubah ke `id`
- [x] **Bug #16**: Vite build gak pernah dijalankan
- [x] **Bug #17**: Gak ada meta SEO di layout
- [x] **Bug #18**: `.phone-screen` CSS defined twice

---

## 2. Auth System (Manual, Opsi C) - Estimasi: ~2 jam

### Step 1: Install Package
- [x] `composer require laravel/socialite` (untuk Google OAuth)

### Step 2: Database
- [x] Migration: `add_role_to_users_table` (tambah `google_id` nullable unique, `avatar` nullable, `role` ENUM: user/admin default user)
- [x] Seeder: `AdminSeeder.php` (akun admin default: admin@rangkita.com)

### Step 3: Model
- [x] Update `User.php` (tambah `google_id`, `avatar`, `role` ke fillable + casts)

### Step 4: Controller
- [x] `AuthController.php` (showLogin, login, showRegister, register, logout, redirectToGoogle, handleGoogleCallback, dashboard)

### Step 5: Middleware
- [x] `AdminMiddleware.php` (cek role admin)
- [x] Register middleware di `bootstrap/app.php`

### Step 6: Routes
- [x] Auth routes guest (login, register, Google OAuth)
- [x] Authenticated routes (logout, dashboard)
- [x] Admin route group (prefix: `/admin`, middleware: auth+admin)

### Step 7: Views
- [x] `auth/login.blade.php` (form email + password, link register)
- [x] `auth/register.blade.php` (form name + email + password, link login)
- [x] `auth/dashboard.blade.php` (welcome message "Selamat datang, [nama]!")

### Step 8: Config
- [x] Update `config/services.php` (tambah config google untuk Socialite)
- [x] Update `.env` (GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REDIRECT_URI)

### Step 9: Post-Install Setup
- [x] `php artisan migrate`
- [x] `php artisan db:seed --class=AdminSeeder`
- [x] Test flow login/register/logout

---

## 3. Quiz CPNS + Midtrans Payment - Estimasi: ~3.5 jam

### Database
- [ ] Migration: `question_packages` (id, category, name, slug, total_questions, difficulty, price, is_active)
- [ ] Migration: `questions` (id, package_id, question_text, option_a/b/c/d, correct_answer, explanation, difficulty)
- [ ] Migration: `quiz_sessions` (id, user_id, package_id, mode, score, answers JSON, time_spent, time_limit)
- [ ] Migration: `transactions` (id, user_id, package_id, order_id, gross_amount, payment_type, status, snap_token)
- [ ] Migration: `user_access` (id, user_id, package_id, transaction_id, access_granted)
- [ ] Seeder: `QuestionPackageSeeder.php` (9 paket: 3 per kategori TWK/TIU/TKP)
- [ ] Seeder: `QuestionSeeder.php` (~135 soal total)

### Controller
- [ ] `CpnsController.php` (index, category, quiz, submit, result)
- [ ] `PaymentController.php` (create, callback, success)

### Config
- [ ] `config/midtrans.php` (server_key, client_key, is_production)
- [ ] Update `.env` (MIDTRANS_SERVER_KEY, MIDTRANS_CLIENT_KEY)

### Views
- [ ] `cpns.blade.php` (UPDATE: 3 kategori + jumlah paket)
- [ ] `cpns-category.blade.php` (BARU: list paket + pilihan mode)
- [ ] `cpns-quiz.blade.php` (BARU: halaman quiz + timer)
- [ ] `cpns-result.blade.php` (BARU: hasil + rekap)
- [ ] `cpns-payment-success.blade.php` (BARU: sukses bayar)

### Install Package
```bash
composer require midtrans/midtrans-php
```

### Alur Pembayaran
1. User pilih paket berbayar → klik "Beli & Mulai"
2. Backend buat transaksi → dapat snap_token dari Midtrans
3. Frontend buka popup Midtrans Snap
4. User bayar (transfer/e-wallet/kartu)
5. Midtrans callback → backend update status → grant akses
6. User redirect → mulai quiz

---

## 4. Database Undangan - Estimasi: ~3 jam

### Database
- [ ] Migration: `templates` (id, slug, name, style, theme_class, description, features JSON, icon)
- [ ] Migration: `weddings` (id, slug, template_id, groom/bride data, wedding_date, events, maps_url, status)
- [ ] Migration: `wedding_gallery` (id, wedding_id, photo_path, caption, sort_order)
- [ ] Migration: `wedding_wishes` (id, wedding_id, guest_name, message, is_approved)
- [ ] Seeder: `TemplateSeeder.php` (6 template: Elegant, Minimalis, Floral, Modern, Classic, Royal)
- [ ] Seeder: `WeddingSeeder.php` (data demo)

### Controller
- [ ] `AdminWeddingController.php` (CRUD undangan)
- [ ] `WeddingController.php` (public: show, addWish)

### Views
- [ ] `admin/weddings/index.blade.php` (list undangan)
- [ ] `admin/weddings/create.blade.php` (form input data)
- [ ] `admin/weddings/edit.blade.php` (form edit)
- [ ] `undangan-public.blade.php` (public view berdasarkan slug)

### Alur
1. Admin input data undangan lewat form
2. Data disimpan ke DB, slug otomatis dibuat
3. Admin copy link: `/undangan/{slug}`
4. User buka link → lihat undangan

---

## 5. Database Artikel - Estimasi: ~3.5 jam

### Database
- [ ] Migration: `categories` (id, name, slug, icon, sort_order)
- [ ] Migration: `tags` (id, name, slug)
- [ ] Migration: `articles` (id, category_id, author_id, title, slug, excerpt, content LONGTEXT, featured_image, status draft/published, SEO fields)
- [ ] Migration: `article_tag` (pivot: article_id, tag_id)
- [ ] Seeder: `CategorySeeder.php` (4 kategori: Undangan, CPNS, Produk Digital, Rangkita)
- [ ] Seeder: `TagSeeder.php` (5 tags: tips, tutorial, panduan, berita, inspirasi)
- [ ] Seeder: `ArticleSeeder.php` (migrate 4 artikel existing)

### Models
- [ ] `Article.php` (belongsTo Category, belongsToMany Tags, belongsTo User)
- [ ] `Category.php` (hasMany Articles)
- [ ] `Tag.php` (belongsToMany Articles)

### Controller
- [ ] `AdminArticleController.php` (CRUD artikel + image upload)
- [ ] `ArticleController.php` (public: index, show, byCategory, byTag)

### Views
- [ ] `admin/articles/index.blade.php` (list artikel + filter)
- [ ] `admin/articles/create.blade.php` (form tambah + SEO settings)
- [ ] `admin/articles/edit.blade.php` (form edit)
- [ ] `artikel.blade.php` (UPDATE: featured image, tags, filter by category)
- [ ] `artikel-detail.blade.php` (UPDATE: SEO meta, author, views count)
- [ ] `layouts/app.blade.php` (UPDATE: yield meta tags)

### Fitur
- CRUD admin panel dengan image upload
- Status draft/publish
- Kategori + Tags (many-to-many)
- SEO meta tags (title, description, keywords)
- View counter
- Filter by category/tag

---

## Ringkasan Estimasi Waktu

| No | Modul | Estimasi |
|----|-------|----------|
| 1 | Bug Fixing (18 issues) | ~1.5 jam |
| 2 | Auth System | ~2 jam |
| 3 | Quiz CPNS + Midtrans | ~3.5 jam |
| 4 | Database Undangan | ~3 jam |
| 5 | Database Artikel | ~3.5 jam |
| **Total** | | **~13.5 jam** |

## File Stats (Setelah Semua Selesai)

| Kategori | File Baru | File Update |
|----------|-----------|-------------|
| Auth | 7 | 4 |
| Quiz CPNS | 12 | 3 |
| Payment | 4 | 2 |
| Undangan | 11 | 1 |
| Artikel | 15 | 3 |
| Lainnya | 0 | 5 |
| **Total** | **49** | **18** |

# NOTES

Proyek Rangkita adalah website landing page & ekosistem digital dengan Laravel 13. Terdapat 19 rute halaman, 6 template undangan, 4 produk, dan 4 artikel SEO. CSS custom sekitar 2083 baris. Database users aktif (migrate + seed sudah jalan), data produk/template/artikel masih hardcoded di controller.

## Behavior AI (opencode)

- `opencode.json` di root proyek: config yang nge-load `AGENTS.md` + `SUMMARY.md` sebagai instructions + mengatur model per agent (plan = `opencode/mimo-v2.5-free`, build = `opencode/deepseek-v4-flash-free`).
- `.opencode/agent/review.md`: agent review (primary mode, `opencode/mimo-v2.5-free`) — review code changes sebelum commit + progress tracking (cross-check TODO checkbox di AGENTS.md dengan git diff).
- `AGENTS.md` punya section `# BEHAVIOR RULES` (17 sub-section): Bahasa & Gaya Bicara, Thorough tapi Terstruktur, Konfirmasi + Jelasin, Expert/Professional, Batasan, Kualitas Kerja, Proyek & Git, Komunikasi, Plan vs Build, Problem Decomposition, Root Cause Analysis, Proactive Issue Detection, Ecosystem Awareness, Testing Mindset, Refactoring Instinct, Code Review, Token Management.
- Ganti mode plan ↔ build ↔ review cukup tekan **Tab** atau **Shift+Tab** (dikonfigurasi via `tui.json` — Tab = `agent_cycle`, Shift+Tab = `agent_cycle_reverse`, `prompt.autocomplete.complete` dimatikan dari Tab biar gak konflik).

## Auth System (Manual, Opsi C)

- **Approach**: Custom auth tanpa Laravel Breeze — konsisten sama arsitektur existing (tanpa Vite/Tailwind, CSS via `asset()`).
- **Packages**: Hanya `laravel/socialite` untuk Google OAuth.
- **Files**: 7 baru (migration, seeder, AuthController, AdminMiddleware, 3 views) + 4 edit (User model, routes/web.php, config/services.php, bootstrap/app.php). `.env` diupdate tapi gitignored.
- **Fitur**: Login, Register, Logout, Google OAuth, role-based access (user/admin).
- **Security**: `Hash::make`/`Hash::check`, CSRF auto-handle, session-based auth via `Auth::attempt()`.
- **Admin default**: admin@rangkita.com (via `AdminSeeder`).
- **Routes**: 19 rute web (10 publik + 6 guest + 2 auth + 1 admin), grup `guest`/`auth`/`admin` + middleware alias `admin`.
- **Status**: SELESAI 9/9 step — migrate + seed + test flow sukses.
- **Pull workflow di komputer rumah**: `git pull` → `composer install` (kalau ada dependency baru) → `php artisan migrate` → `php artisan db:seed --class=AdminSeeder` → `php artisan config:clear` → test flow.

## Sistem Template Undangan

6 template (Elegant, Minimalis, Floral, Modern, Classic, Royal) semua berbagi satu Blade. Alur: listing (`/undangan`) -> preview (`/undangan/preview/{slug}`) & detail (`/undangan/template/{slug}`). Detail & preview membaca data dari `getWeddingTemplates()` di PageController, preview juga pakai `getDummyWeddingData()`.

Temuan masalah:
- Link ke detail page tidak ada di listing (tombol langsung ke preview)
- Nama pengantin hardcoded di `template-detail.blade.php`
- Google Maps URL masih `#` (data `maps_url` tidak didefinisikan)
- Gallery hanya placeholder text
- Form ucapan (wish) tidak fungsional (tanpa backend)
- ~~CSS duplikasi/overlap: blok 1540-1857 vs 1859-2065 (V1.6 override)~~ → sudah bersih setelah pull, blok V1.6 tidak dipakai
- ~~JS hanya countdown timer inline~~ → sekarang ada wish form JS (kirim ucapan frontend-only) + cinematic opening + countdown
- Tombol WhatsApp CTA (V1.6 lokal) tidak dipakai - butuh `$whatsappNumber` di controller

## Struktur Folder

```
C:\laragon\www\rangkita\
├── app/                        Kode aplikasi PHP (7 file)
│   ├── Http/Controllers/
│   │   ├── Controller.php      Base controller abstrak (8 baris)
│   │   ├── PageController.php  Logika halaman publik (378 baris)
│   │   └── AuthController.php  Auth: login/register/logout/Google OAuth/dashboard
│   ├── Http/Middleware/
│   │   └── AdminMiddleware.php Cek role admin (abort 403)
│   ├── Models/User.php         Model User (fillable + google_id/avatar/role)
│   ├── Providers/AppServiceProvider.php
│   └── View/Components/navbar.php
├── resources/
│   └── views/
│       ├── landing.blade.php   Homepage utama (206 baris)
│       ├── auth/               Halaman auth (login, register, dashboard)
│       ├── admin/              Halaman admin (dashboard)
│       ├── components/navbar.blade.php
│       ├── layouts/app.blade.php   Layout utama + SEO meta (35 baris)
│       └── pages/              9 halaman
│           ├── produk.blade.php
│           ├── produk-detail.blade.php
│           ├── undangan.blade.php
│           ├── template-detail.blade.php
│           ├── template-preview.blade.php
│           ├── cpns.blade.php
│           ├── artikel.blade.php
│           ├── artikel-detail.blade.php
│           └── kontak.blade.php
├── routes/
│   ├── web.php                 19 rute (10 publik + 6 guest + 2 auth + 1 admin)
│   └── console.php
├── database/
│   ├── factories/UserFactory.php
│   ├── migrations/             4 migration (3 default + add_role_to_users_table)
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── AdminSeeder.php     Akun admin default
├── config/                     10 file config (services.php + config google)
├── public/
│   ├── css/rangkita.css        CSS CUSTOM UTAMA (2083 baris)
│   └── images/logo-rangkita.png
├── storage/                    Cache, sessions, logs, uploads
├── tests/                      4 file (Pest PHP, semua default)
├── bootstrap/
├── vendor/                  Dependencies PHP
├── .opencode/agent/         Agent config (review.md)
└── file config root: .env, composer.json, package.json, opencode.json, tui.json
```

## Statistik Proyek

| Komponen | Jumlah | Keterangan |
|----------|--------|------------|
| Rute web | 19 | 10 publik + 6 guest + 2 auth + 1 admin |
| Controllers | 3 | 1 base abstrak + PageController + AuthController |
| Middleware | 1 | AdminMiddleware (role admin) |
| Models | 1 | User (fillable + google_id/avatar/role) |
| View files | 16 | 1 root + 1 layout + 1 komponen + 9 pages + 3 auth + 1 admin |
| Blade components | 1 | navbar |
| Layout files | 1 | app.blade.php |
| CSS custom | 2083 baris | public/css/rangkita.css (blok V1.6 sudah tidak dipakai) |
| Migrations | 4 | 3 default + add_role_to_users_table |
| Seeders | 2 | DatabaseSeeder + AdminSeeder |
| Config files | 10 | services.php + config google |
| Test files | 4 | Semua default |

## Data Hardcoded di PageController

| Data | Jumlah |
|------|--------|
| Produk | 4 (Undangan Nikahan, Soal CPNS, Produk Digital, Artikel SEO) |
| Artikel | 4 |
| Template undangan | 6 (Elegant, Minimalis, Floral, Modern, Classic, Royal) |
| Data dummy wedding | 1 set (pengantin, akad, resepsi, gallery, wishes) |

## Pola Arsitektur

- **Multi Controller Pattern**: PageController (10 rute publik) + AuthController (auth + Google OAuth)
- **Database Aktif**: users table + role (migrate + seed sudah dijalankan), data lain masih hardcoded
- **Custom CSS Dominan**: 2083 baris rangkita.css, asset langsung via `asset()`
- **Auth Aktif**: login/register/logout/Google OAuth, role-based access (user/admin)
- **No API**: Hanya web routes

## Teknologi

- Laravel 13.8 / PHP ^8.3 / MySQL (DB "rangkita", aktif setelah migrate)
- `laravel/socialite` ^5.29 untuk Google OAuth
- Pest PHP ^4.7 untuk testing
- Font Instrument Sans (Bunny CDN)

# CHANGELOG

## Ses 17 Agu 2026 - Auth System Selesai (9/9 step)

- **Step 3 selesai**: `User.php` diupdate — `#[Fillable(['name', 'email', 'password', 'google_id', 'avatar', 'role'])]`, `php -l` lolos
- **Step 4 selesai**: `AuthController.php` baru (8 method: showLogin, login, showRegister, register, logout, redirectToGoogle, handleGoogleCallback, dashboard)
  - Login: `Auth::attempt` + `session()->regenerate()` (session fixation protection)
  - Register: validasi `unique:users,email` + `Hash::make` + auto-login
  - Google OAuth: `Socialite::driver('google')`, fallback match by `google_id` OR `email`, kalau user existing daftar manual → `google_id` di-update, password random `str()->random(32)` buat user baru
  - Logout: `session()->invalidate()` + `regenerateToken()` (anti CSRF session reuse)
- **Step 5 selesai**: `AdminMiddleware.php` baru — cek `auth()->guest() || role !== 'admin'` → `abort(403)`, registered sebagai alias `admin` di `bootstrap/app.php`
- **Step 6 selesai**: `routes/web.php` jadi 19 rute (10 publik + 6 guest + 2 auth + 1 admin)
  - Grup `guest`: login, login.submit, register, register.submit, google.redirect, google.callback
  - Grup `auth`: logout (POST), dashboard
  - Grup `admin` (prefix `/admin`, middleware `['auth', 'admin']`): placeholder `admin.dashboard`
- **Step 7 selesai**: 3 view baru — `auth/login.blade.php`, `auth/register.blade.php`, `auth/dashboard.blade.php` + `admin/dashboard.blade.php` (placeholder). Semua form pakai `@csrf`, error validation, `old()` re-populate
- **Step 8 selesai**: `config/services.php` + block `google` (client_id, client_secret, redirect), `.env` + `GOOGLE_CLIENT_ID/SECRET/REDIRECT_URI` (kosong, tinggal diisi dari Google Cloud Console), `.env.example` diupdate biar template ke-track git
- **Step 9 selesai**: DB `rangkita` dibuat di MySQL (ternyata belum ada), `php artisan migrate --force` (4 migration jalan), `db:seed --class=AdminSeeder`, verifikasi role=admin + hash valid + `Auth::attempt` sukses
- **File baru**: AuthController, AdminMiddleware, migration `add_role_to_users_table`, AdminSeeder (dari step 2), 3 view auth + 1 admin dashboard
- **File update**: User.php, bootstrap/app.php, routes/web.php, config/services.php, .env, .env.example, composer.json, composer.lock
- **Verifikasi**: `php -l` semua lolos, `view:cache` sukses, `route:list` 23 route (19 app + 4 vendor), tinker auth test sukses
- **Status**: belum di-commit

## Ses 14 Agu 2026 - Behavior Rules Upgrade: Build Mode Mentoring + Review Progress Tracking

- **Build mode diubah** dari "AI eksekusi langsung" → "AI ajarin step by step, user kerjain sendiri dulu"
  - AI kasih instruction detail: file path, kode yang ditulis, command yang dijalankan
  - User coba sendiri dulu, kalau stuck → user bilang minta bantu → AI eksekusi langsung
  - AI nunggu feedback setiap step sebelum lanjut ke step berikutnya
- **Review mode ditambah progress tracking** (`.opencode/agent/review.md`)
  - Review agent baca TODO checkbox di AGENTS.md → cross-reference dengan git diff
  - Highlight step yang udah dicentang tapi gak ada di diff, atau kode baru yang gak ke-track di TODO
  - End with progress summary: "Progress: Step X-Y selesai, Step Z remaining"
- **File diubah**: `AGENTS.md` (section Plan vs Build + NOTES) + `.opencode/agent/review.md`
- **Status**: belum di-commit

## Ses 14 Agu 2026 - Auth System Mulai (Manual, Opsi C) - Step 1 & 2

- **TODO Auth System di-upgrade ke plan 9 langkah** (hapus Breeze, manual auth), disinkronin di `AGENTS.md` & `SUMMARY.md`
- **Step 1 selesai**: `composer require laravel/socialite` (v5.29.0 + 5 dependency pendukung) — `composer.json` & `composer.lock` ke-update
- **Step 2 selesai**:
  - Migration `2026_08_14_062208_add_role_to_users_table.php` — tambah `google_id` (nullable unique), `avatar` (nullable), `role` ENUM (user/admin, default user)
  - Seeder `AdminSeeder.php` — akun admin default `admin@rangkita.com` (password `admin12345`, pakai `updateOrCreate` biar idempotent)
- **Catatan**: migration & seeder belum dijalankan (Step 9), seeder `role` butuh Step 3 (User model fillable) biar kepakai
- **Status**: belum di-commit (bareng perubahan memory files sesi behavior rules sebelumnya)

## Ses 14 Agu 2026 - Behavior Rules Upgrade: Expert Full Stack Developer

- **Behavior rules di `AGENTS.md` diupgrade dari 10 → 17 sub-section** (persona AI jadi senior full-stack dev)
- **Section diubah (9)**:
  - `Bahasa & Gaya Bicara` — jawaban technically weighted, pakai istilah teknis yang tepat + padanan Indonesia
  - `Simpel & Gak Ribet` → `Thorough tapi Terstruktur` — boleh jawab panjang kalau perlu, pakai heading/list
  - `Konfirmasi + Jelasin` — wajib jelasin kenapa pilih approach, trade-off analysis
  - `Mentor/Guru` → `Expert/Professional` — act sebagai senior full-stack dev, kasih solusi proven, highlight code smell
  - `Batasan` — boleh suggest alternatif tanpa ditanya, tapi TETAP user yang mutusin (format "Alternatif: ... — kelebihan/kekurangan")
  - `Kualitas Kerja` — apply design patterns, Laravel conventions, hindari God Class
  - `Proyek & Git` — ikuti naming convention codebase existing
  - `Komunikasi` — insight berbobot, highlight potensi issue (security/performance/maintainability)
  - `Plan vs Build` — plan include trade-off analysis, build tetap jelasin singkat kenapa
- **Section baru (7)**: `Problem Decomposition`, `Root Cause Analysis`, `Proactive Issue Detection`, `Ecosystem Awareness`, `Testing Mindset`, `Refactoring Instinct`, `Code Review`
  - User jawab 3 preferensi: (1) salah user → tunjukin + fix tapi tetap dibimbing, (2) saran alternatif → langsung suggest tapi user yang mutusin, (3) code review → detail per baris
  - User minta tambahan "biar AI pinter" → tambah 6 section baru (decompose, root cause, proactive detection, ecosystem, testing, refactoring)
- **Referensi di `SUMMARY.md`** diupdate dari "10 sub-section" → "17 sub-section" + daftar section baru

## Ses 11 Agu 2026 - Bug Fix 18/18 Selesai + Review Agent + Config Centralize

- **Medium bug fix (Bug #5-#9, 5 selesai)**, commit `921b851`:
  - Bug #5: `rel="noopener noreferrer"` ditambah di `produk-detail.blade.php:48`
  - Bug #6: CSS selector `.location-section button` → `.location-section button, .location-section a` di `rangkita.css`
  - Bug #7: Hardcoded "Dika & Nur" → "Pasangan Anda" di `undangan.blade.php`
  - Bug #8: `name` attribute ditambah di 4 form input `kontak.blade.php`
  - Bug #9: `APP_DEBUG=true` → `false` di `.env` (file gitignored, gak ke-commit)
- **High-impact bug fix**: Config centralize WhatsApp + SEO meta + hapus dead Vite pipeline, commit `cadb15c`:
  - Bug #11-#12: Nomor WA, email, instagram dipindah ke `config/services.php` + `.env` (`WHATSAPP_NUMBER`, `CONTACT_EMAIL`, `CONTACT_INSTAGRAM`), hardcoded di controller & blade dibersihin
  - Bug #17: `layouts/app.blade.php` ditambah meta description, keywords, robots, author + Open Graph tags (og:title, og:description, og:type, og:site_name, og:url), support `@section` per halaman
  - Bug #10: Unused import `Request` dihapus dari PageController
  - Bug #15: Locale `en` → `id` di `.env` + `config/app.php` default
  - Bug #18: Duplikat `.phone-screen` CSS dibersihin (merge ke satu definisi)
  - Bug #13: Hapus file unused — `welcome.blade.php`, `landing1.blade.php`, `app.js`, `app.css`
  - Bug #14-#16: Hapus pipeline Vite/Tailwind yang gak dipake — `vite.config.js`, `package-lock.json`, dependensi Vite/Tailwind dari `package.json`, script vite dari `composer.json` (setup & dev script). Total **-2336 baris** code dead
- **Review agent baru**, commit `c738b4e`:
  - `.opencode/agent/review.md` — agent review (primary mode, `opencode/mimo-v2.5-free`) untuk review code sebelum commit
  - Tab sekarang cycle **plan → build → review → plan**; Shift+Tab reverse
- **Memory files** diupdate: TODO semua dicentang (18/18), struktur folder & statistik proyek direvisi sesuai cleanup, Teknologi (Vite/Tailwind dihapus)
- **Verifikasi**: `php -l` lolos, `view:cache` sukses, config cache sukses, `config('services.whatsapp.number')` terbaca `6285945155673`
- **Push**: `921b851`, `cadb15c`, `c738b4e` ke `origin/main`

## Ses 11 Agu 2026 - Critical & High Bug Fix + Behavior AI Update

- **Critical bug fix (2 selesai)**:
  - Bug #1: Data wedding hardcode di template-detail → tambah `$wedding = $this->getDummyWeddingData()` di PageController + ganti hardcoded di Blade
  - Bug #2: Link detail page gak ada di listing → tambah tombol "Lihat Detail" ke `/undangan/template/{slug}`
- **High bug fix (2 selesai)**:
  - Bug #3: `<script>` di luar `</body>` → pindah `</body>` ke sesudah script terakhir
  - Bug #4: Countdown script gak ada `DOMContentLoaded` → wrap dalam event listener
- **Behavior AI update**: Tambah `# BEHAVIOR RULES` (10 sub-section) di AGENTS.md + sinkron ke SUMMARY.md
  - 2 sub-section baru: `## Plan vs Build` (plan = step-by-step detail + cara fix, build = eksekusi langsung) + `## Token Management` (warning sebelum token abis)
- **Verifikasi**: `php -l` PageController lolos, `php artisan view:cache` sukses
- **Status**: 4 bug fix + behavior rules + TODO update belum di-commit

## Ses 6 Agu 2026 - Update Memory Files (finish)

- **Finalisasi `AGENTS.md` & `SUMMARY.md`**: dokumentasi seluruh pekerjaan sesi planning (5 modul besar) dikunci di memory
- **TODO lengkap**: 18 bug fix + Auth System + Quiz CPNS & Midtrans Payment + Database Undangan + Database Artikel (total ~13.5 jam kerja, 49 file baru + 17 file update)
- **Changelog dirapikan**: urutan entry dikembalikan kronologis, Status Sekarang dipindah ke akhir, duplikat dihapus
- **Karakter rusak dirapikan**: `?` yang seharusnya panah (`→`) diganti biar memory gampang dibaca AI
- **Status**: file memory belum di-commit (HEAD `359eb40`), plan siap dieksekusi sesuai prioritas TODO

## Ses 4 Agu 2026 (lanjutan) - Bug Fix + Behavior Rules + Update /finish

- **Audit codebase lengkap**: ditemukan 45 issue (8 bug, 9 missing feature, 16 code quality, 9 UX, 3 unused files) via explore agent
- **Bug fix (5 bug selesai, commit `359eb40`)**:
  - Contact form error di `kontak.blade.php` - hapus `onsubmit="sendToWhatsapp(event)"` yang gak terdefinisi, biarin `addEventListener` yang handle
  - Google Maps link `#` di preview - tambah `maps_url` di `getDummyWeddingData()` (PageController) + update `template-preview.blade.php`
  - Google Maps dead button di detail - ganti `<button>` jadi `<a>` ke Google Maps
  - Email mismatch - tampilan disamain jadi `andikafadil28@gmail.com` (sesuai link mailto)
  - Marketplace link dead end - `href="#"` → `/produk`
  - HTML structure broken di `template-preview.blade.php` - pindah script dari antara head/body ke akhir file sebelum `</html>`
- **Verifikasi**: `php -l` PageController lolos, `php artisan view:cache` sukses (semua Blade compile), view:clear
- **Push + Deploy**: commit `359eb40` di-push ke `origin/main`, user diajarin deploy Scenario A ke server (git pull, npm build, chown, optimize:clear, reload php8.3-fpm)
- **TODO AGENTS.md diupdate**: tambah section "Bug Fix (Selesai)" dengan 5 item centang
- **Behavior rules baru di AGENTS.md**: `## Plan vs Build` (plan = kasih step-by-step instruction, build = eksekusi langsung) + `## Token Management` (warning kalau token mau abis biar bisa /finish)
- **Update `/finish`**: `commands/finish.md` sekarang suruh update AGENTS.md DAN SUMMARY.md; `scripts/finish.ps1` validasi dua file ($AgentsFile + $SummaryFile) sebelum sync ke server memory
- **Status**: AGENTS.md masih uncommitted (behavior rules + TODO update), SUMMARY.md update sesi ini

## Ses 31 Jul 2026 - Setup Deployment Workflow

- **Diskusi kemampuan opencode**: dibahas kemungkinan konek SSH ke server VirtualBox. Hasil: tool bash tidak bisa input password SSH interaktif, `plink`/`sshpass` belum terinstall, WSL cuma Docker Desktop. Keputusan user: Metode A (guided deploy), SSH key ditunda
- **Analisis percakapan ChatGPT (share link)**: dipahami arsitektur server (VirtualBox Ubuntu 24.04, hostname `web-dikadevit`, username `dika`, SSH `-p 2222 dika@127.0.0.1`, domain `dikadevit.my.id` via Cloudflare Tunnel Healthy, Tailscale untuk SSH dari luar, repo `/var/www/rangkita`)
- **AGENTS.md**: Tambah section `DEPLOYMENT` (info server, trigger "deploy", workflow commit+push, 3 scenario deploy A/B/C + catatan)
- **Pull terbaru dari GitHub**: 3 commit (`update mobile`, `update animasi`, `update readme`)
  - `README.md` direvisi, `navbar.blade.php` diupdate, `template-preview.blade.php` +359/-… baris (countdown grid, gallery, lokasi, form wish fungsional via JS), `rangkita.css` +226 baris (WISH FORM + CINEMATIC INVITATION OPENING)
- **Resolve konflik**: `rangkita.css` & `template-preview.blade.php` conflict saat stash pop → di-resolve pakai versi remote (lebih baru & benar). Perubahan V1.6 lokal (tombol WA CTA) disimpan di `stash@{0}` sebagai backup karena pakai variabel `$whatsappNumber` yang tidak ada di controller
- **Commit + Push**:
  - `e56e06f` `update AGENTS.md deployment workflow + SUMMARY` (AGENTS.md + SUMMARY.md baru)
  - `5f9807b` `update SUMMARY changelog deploy workflow + pull` (SUMMARY.md)
- **Stash tersimpan**: `stash@{0}` = perubahan V1.6 lama (backup, belum dihapus)

## Ses 4 Agu 2026 - Setup Behavior AI opencode

- **Diskusi behavior AI**: user minta AI opencode di-set supaya Bahasa Indonesia terus, sering konfirmasi sembari jelasin, gak over (jangan banyak ngusulin fitur), simpel/gak ribet, gaya gen-z santai bisa bercanda, dan jadi mentor/guru (user lagi belajar). Saran tambahan diambil semua: kualitas kerja (verifikasi sebelum klaim, error = materi belajar, jujur), proyek & git (follow konvensi, git hygiene, pakai konteks proyek), komunikasi (pertanyaan berbobot, respect prioritas TODO).
- **`opencode.json` (baru)**: config root proyek dengan `"instructions": ["AGENTS.md"]` supaya behavior rules ke-load AI.
- **`AGENTS.md`**: Tambah section `# BEHAVIOR RULES` berisi 10 sub-section (Bahasa & Gaya Bicara, Simpel & Gak Ribet, Konfirmasi + Jelasin, Mentor/Guru, Batasan, Kualitas Kerja, Proyek & Git, Komunikasi, Plan vs Build, Token Management).
- **Catatan**: config baru aktif setelah restart opencode.

## Ses 4 Agu 2026 (lanjutan) - Fix Model ID opencode Agent

- **Masalah**: model agent gak berubah saat ganti plan/build, selalu fallback ke default (`opencode/deepseek-v4-flash-free`).
- **Akar masalah**: model ID di `opencode.json` obsolete/gak ada di provider `opencode/`. Dicek via `opencode models` - yang valid cuma `opencode/deepseek-v4-flash-free` dan `opencode/mimo-v2.5-free`. Config lama pakai `opencode/deepseek-v3-0324` (itu versi openrouter, bukan opencode) & `opencode/mimo-v2-free` (udah jadi v2.5).
- **`opencode.json` diupdate**: `agent.plan.model` dan `agent.build.model` diganti ke ID yang valid.
- **`AGENTS.md` & `SUMMARY.md`**: perbarui referensi model per agent di section Behavior AI.
- **Catatan**: config gak hot-reload → harus restart opencode; Tab (`agent_cycle`) baru bisa ngeganti model abis restart.

## Ses 4 Agu 2026 (lanjutan) - Setup Agent Model opencode + Push

- **Diskusi model per agent**: user mau opencode pilih AI otomatis per tugas - plan pakai Mimo, build pakai DeepSeek. Dicek via skill `customize-opencode` + schema `opencode.ai/config.json` + docs keybinds.
- **Temuan keybind Tab**: ganti mode plan ↔ build udah default via tombol **Tab** (`agent_cycle`), reverse `Shift+Tab`. Bisa dikustom lewat `tui.json` tapi tidak perlu.
- **`opencode.json` diupdate**: tambah `agent.plan.model = opencode/mimo-v2-free` dan `agent.build.model = opencode/deepseek-v3-0324`.
- **Commit + Push**:
  - `5a7d32b` `setup behavior AI opencode + config agent plan/build` (opencode.json baru + AGENTS.md behavior rules + SUMMARY.md)
- **Catatan**: tinggal restart opencode biar config aktif; pull di komputer rumah via `git pull --ff-only origin main` (tidak bisa di-remote dari sini).

## Ses 4 Agu 2026 (lanjutan) - Fix Tab Keybind + Bikin tui.json

- **Masalah**: pencet Tab muncul kotak autocomplete, bukan ganti agent build↔plan. Shift+Tab juga gak jalan.
- **Akar masalah**: default keybind `tab` bentrok antara `agent_cycle` (ganti agent) dan `prompt.autocomplete.complete` (autocomplete di kolom ketik). Terminal juga bisa nangkep shift+tab duluan.
- **Solusi**: bikin `tui.json` di root proyek:
  - `agent_cycle` = `tab`
  - `agent_cycle_reverse` = `shift+tab`
  - `prompt.autocomplete.complete` = `none` (matikan autocomplete dari Tab)
- **File baru**: `tui.json` di root proyek
- **Update AGENTS.md & SUMMARY.md**: tambah referensi tui.json + penjelasan keybind Tab/Shift+Tab
- **Catatan**: config TUI gak hot-reload → harus restart opencode

## Ses 4 Agu 2026 (lanjutan) - Planning Besar 5 Modul

- **Planning selesai**: Diskusi panjang tentang 5 modul utama yang akan dibangun
- **Modul 1 - Bug Fixing**: 18 issues teridentifikasi (2 critical, 2 high, 6 medium, 8 low)
  - Critical: Data wedding hardcode di template-detail, link detail page gak ada di listing
  - High: Script di luar body, countdown gak ada DOMContentLoaded wrapper
  - Medium: Missing rel noopener, CSS selector mismatch, hardcoded names, form inputs, APP_DEBUG
  - Low: Unused imports, duplicated WhatsApp number, unused files, font mismatch, locale, Vite, SEO, CSS duplikasi
- **Modul 2 - Auth System**: Full auth dengan Google OAuth + register manual + admin role
  - User model update: tambah google_id, avatar, role
  - AuthController: register, login, logout, Google OAuth
  - AdminMiddleware: cek role admin
  - Views: register, login
- **Modul 3 - Quiz CPNS + Midtrans Payment**: Sistem quiz interaktif dengan pembayaran
  - Database: question_packages, questions, quiz_sessions, transactions, user_access
  - 2 mode: Latihan (tanpa timer) + Test (timer sesuai durasi resmi CPNS)
  - 9 paket soal (3 per kategori TWK/TIU/TKP), ~135 soal total
  - Midtrans Snap: popup pembayaran, callback handling, grant akses
  - Rasio timer: ~54 detik per soal (100 menit / 110 soal SKD CPNS)
- **Modul 4 - Database Undangan**: Pindah data hardcoded ke database
  - Database: templates, weddings, wedding_gallery, wedding_wishes
  - AdminWeddingController: CRUD undangan
  - WeddingController: public view + add wish
  - Alur: admin input → DB → generate slug → user lihat via link
- **Modul 5 - Database Artikel**: Full CMS artikel dengan SEO
  - Database: categories, tags, articles, article_tag (pivot)
  - AdminArticleController: CRUD + image upload + SEO settings
  - ArticleController: public index, show, byCategory, byTag
  - Fitur: draft/publish, featured image, view counter, SEO meta tags
- **Total estimasi**: ~13.5 jam kerja
- **File stats**: 49 file baru + 17 file update = 66 file total
- **AGENTS.md diupdate**: TODO section lengkap dengan semua rencana

## Status Sekarang

- HEAD: `0c44acd` (branch `main`) — Auth System selesai tapi **belum di-commit**
- **Auth System (Manual, Opsi C) SELESAI 9/9 step** — migrate + seed + test flow sukses, login admin terverifikasi
- **Bug Fixing SELESAI 18/18** (commit `921b851` medium, `cadb15c` high-impact/cleanup, `c738b4e` review agent)
- **Behavior rules diupgrade ke 17 sub-section** (commit `0c44acd`) — persona AI jadi expert full-stack dev
- **Behavior rules diupdate**: Build mode mentoring (step-by-step + user kerjain sendiri), review mode progress tracking — belum di-commit
- Worktree berubah: AGENTS.md, SUMMARY.md, composer.json, composer.lock, + Auth System files (AuthController, AdminMiddleware, AdminSeeder, migration, 4 views) — belum di-commit
- DB `rangkita` aktif: 4 migration jalan, akun admin `admin@rangkita.com` (role admin, hash valid)
- Google Login: `GOOGLE_CLIENT_ID/SECRET` di `.env` masih kosong — tinggal diisi dari Google Cloud Console
- CSS custom: 2083 baris (setelah cleanup `.phone-screen` duplikat dihapus)
- Vite/Tailwind/Instrument Sans pipeline dihapus — site murni pakai `rangkita.css` via `asset()`
- `.opencode/agent/review.md` aktif: Tab = cycle plan → build → review → plan; Shift+Tab reverse
- Deploy workflow aktif: user bilang "deploy" → opencode commit+push lokal → user copy-paste command server (Scenario A/B/C sesuai file yang berubah)
- `tui.json` aktif: Tab = ganti agent, Shift+Tab = reverse, autocomplete dimatikan dari Tab
- **Siap lanjut ke modul berikutnya: Quiz CPNS + Midtrans Payment**
