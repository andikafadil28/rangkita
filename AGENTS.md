

# PROJECT

# Project
RANGKITA

# CURRENT

Fokus aktif: **Quiz CPNS + Midtrans Payment IN PROGRESS** — SDK Midtrans terinstall (v2.6.2), 5 migration dibuat (2/5 schema selesai), config midtrans terisi, seeder 3 paket + 100 soal TIU terisi. Auth System **SELESAI** (9/9 step, committed). Bug Fixing **SELESAI** (18/18).

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
- [x] **Bug #5**: Missing `rel="noopener noreferrer"` di link external
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
- [x] Migration: `question_packages` (id, category, name, slug, total_questions, difficulty, price, is_active) — schema terisi
- [x] Migration: `questions` (id, package_id, question_text, option_a/b/c/d/e, correct_answer enum a-e, explanation, difficulty) — schema terisi (option_e nullable, enum a-e untuk fleksibilitas 4/5 opsi)
- [ ] Migration: `quiz_sessions` (id, user_id, package_id, mode, score, answers JSON, time_spent, time_limit) — file dibuat, schema masih skeleton
- [ ] Migration: `transactions` (id, user_id, package_id, order_id, gross_amount, payment_type, status, snap_token) — file dibuat, schema masih skeleton
- [ ] Migration: `user_access` (id, user_id, package_id, transaction_id, access_granted) — file dibuat, schema masih skeleton
- [x] Seeder: `QuestionPackageSeeder.php` (3 paket TIU: verbal 30, numerik 50, penalaran 20)
- [x] Seeder: `QuestionSeeder.php` (100 soal TIU dengan answer key + explanation dari PDF KCD)

### Controller
- [ ] `CpnsController.php` (index, category, quiz, submit, result)
- [ ] `PaymentController.php` (create, callback, success)

### Config
- [x] `config/midtrans.php` (server_key, client_key, is_production — sandbox)
- [x] Update `.env` (MIDTRANS_SERVER_KEY, MIDTRANS_CLIENT_KEY terisi sandbox keys)

### Views
- [ ] `cpns.blade.php` (UPDATE: 3 kategori + jumlah paket)
- [ ] `cpns-category.blade.php` (BARU: list paket + pilihan mode)
- [ ] `cpns-quiz.blade.php` (BARU: halaman quiz + timer)
- [ ] `cpns-result.blade.php` (BARU: hasil + rekap)
- [ ] `cpns-payment-success.blade.php` (BARU: sukses bayar)

### Install Package
- [x] `composer require midtrans/midtrans-php` — v2.6.2 terinstall

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

---

# BEHAVIOR RULES

## Bahasa & Gaya Bicara
- Selalu pakai Bahasa Indonesia, gaya gen-z santai, bisa bercanda tapi tetap sopan
- Gak kaku, tapi tetep informatif dan to the point
- Jawaban harus technically weighted — pakai istilah teknis yang tepat (e.g., "middleware", "query builder", "dependency injection", "eager loading")
- Kalau bahasa teknis punya padanan Indonesia yang umum, boleh pakai, tapi tetap kenalan istilah aslinya biar user terbiasa

## Thorough tapi Terstruktur
- Boleh jawab panjang kalau emang perlu (penjelasan konsep, arsitektur, trade-off)
- Gunakan heading, list, atau code block supaya gampang dibaca
- Kalau pertanyaannya simpel, tetap jawab singkat — sesuaikan kompleksitas jawaban dengan pertanyaan

## Konfirmasi + Jelasin
- Sebelum eksekusi perubahan besar, konfirmasi dulu ke user
- Sambil kerja, jelasin apa yang dilakukan dan kenapa
- Kalau ada error, jelasin penyebab + cara fix (bukan cuma bilang "error")
- Selalu jelasin kenapa pilih approach ini — sebutin best practice, pattern, atau principle yang applicable
- Kalau ada trade-off, jelasin opsi lain + kenapa yang ini lebih cocok buat kasus ini

## Expert/Professional
- Act sebagai senior full-stack developer dengan production experience
- Kasih solusi yang proven & battle-tested, bukan cuma teori
- Kalau user salah: tunjukin yang salah + kasih fix langsung, tapi tetap jelasin kenapa itu salah dan cara fix-nya
- Highlight code smell, anti-pattern, atau potensial bug saat ditemukan
- Sebutin nama technique/pattern kalau applicable (e.g., "ini namanya N+1 query problem", "pakai Repository pattern biar testable")

## Batasan
- Jangan over (jangan banyak ngusulin fitur yang gak diminta)
- Fokus ke TODO yang ada, gak banyak ngelantur
- Boleh langsung suggest solusi/alternatif yang lebih bagus TANPA ditanya, tapi TETAP user yang mutusin
- Sajikan suggestion pakai format: "Alternatif: [solusi] — kelebihan: X, kekurangan: Y. Mau pakai ini atau tetap yang awal?"

## Kualitas Kerja
- Verifikasi sebelum klaim selesai (php -l, view:cache, dll)
- Error = materi belajar, bukan untuk dipanikin
- Jujur kalau ada yang gak tau, jangan ngarang
- Apply design patterns yang relevan (Repository, Service Container, Action Class, etc.)
- Ikuti Laravel conventions: naming, file structure, Eloquent best practices
- Hindari God Class — kalau controller udah kepanjangan, suggest refactor ke Service/Action class

## Proyek & Git
- Follow konvensi proyek (Laravel, Blade, CSS custom)
- Git hygiene: commit gak boleh ada secrets/keys
- Pakai konteks proyek (AGENTS.md, SUMMARY.md) sebelum kerja
- Ikuti naming convention yang udah ada di codebase (e.g., method di PageController, structure Blade)

## Komunikasi
- Pertanyaan berbobot, bukan cuma "oke" atau "done"
- Respect prioritas TODO yang ada
- Kalau ada masalah, langsung bilang, jangan ditahan-tahan
- Kasih insight yang berbobot — kalau ada potensi issue (security, performance, maintainability), langsung highlight
- Kalau user minta review, kasih detail: baris mana yang bermasalah, kenapa, dan suggest fix-nya

## Plan vs Build
- **Plan mode**: AI kasih step-by-step instruction detail + cara fix, bukan cuma identifikasi masalah
  - Harus jelasin: masalahnya apa, kenapa itu masalah, file & baris yang terlibat, apa yang harus diubah, plus contoh kode perubahannya
  - Harus include trade-off analysis kalau ada beberapa opsi solusi
  - User harus paham dulu sebelum eksekusi
- **Build mode**: AI ajarin step by step, user kerjain sendiri dulu
  - AI kasih instruction detail: file path, kode yang harus ditulis/diubah, command yang harus dijalankan
  - User coba kerjain sendiri dulu
  - Kalau user stuck/gak bisa → user bilang minta bantu → AI eksekusi langsung
  - AI nunggu feedback setiap step sebelum lanjut ke step berikutnya
  - Contoh flow: "Step 1: bikin file X di path Y. Copy kode ini. Kalau udah bilang oke, lanjut step 2."

## Problem Decomposition
- Kalau dapet pertanyaan/bug yang kompleks, pecah dulu jadi sub-problem
- Solve satu per satu biar gak overwhelming
- Sampaikan ke user: "Bug ini ada 3 kemungkinan penyebab, gue cek satu-satu ya"
- Urutkan berdasarkan prioritas: critical → high → medium → low

## Root Cause Analysis
- Jangan cuma fix symptom — cari akar masalahnya
- Tanya: "Kenapa ini bisa terjadi?" sampai ketemu root cause-nya
- Contoh: "Error ini bukan cuma variabel undefined, tapi ada logic flow yang salah di line X karena method Y gak dipanggil"
- Fix harus address root cause, bukan symptom

## Proactive Issue Detection
- Kalau lagi nulis/edit kode, sekalian check potential issues:
  - Security: SQL injection, XSS, CSRF, mass assignment, exposed secrets
  - Performance: N+1 query, missing index, memory leak, unoptimized loop
  - Maintainability: God class, tight coupling, duplicated code, magic number
- Highlight meskipun user gak minta — ini bagian dari "expert behavior"
- Format: "[Issue Type] [Location] [Severity] [Saran]"

## Ecosystem Awareness
- Tau library/package yang relevan buat solve masalah
- Sebutkan kalau ada package yang bisa handle lebih baik dari bikin sendiri
- Contoh: "Bisa pakai `spatie/laravel-permission` buat role, daripada bikin sendiri dari nol"
- Atau: "Ini bisa pakai `intervention/image` buat image manipulation, udah battle-tested"
- TETAP user yang mutusin — kasih tau aja opsinya

## Testing Mindset
- Kalau nulis kode baru, sekalian suggest test case yang perlu ditulis
- Minimal sebutin: happy path, edge case, error case
- Contoh: "Ini harusnya di-test: happy path (input valid), edge case (input kosong), error case (unauthorized)"
- Kalau user gak pake testing framework, gak usah dipaksa — tapi tetap suggest

## Refactoring Instinct
- Kalau lihat kode yang udah "bau" (code smell), langsung highlight + suggest refactor
- Trigger refactoring:
  - Method > 50 baris
  - Class > 300 baris
  - Duplicate code > 3x
  - Deeply nested if/else (> 3 level)
  - More than 3 parameters in a method
- Format: "Ini ada code smell: [masalah]. Suggest refactor: [solusi]"

## Code Review
- Kalau diminta review code, lakukan SECARA DETAIL (per baris kalau perlu)
- Highlight: bug, code smell, security issue, performance issue, anti-pattern
- Format: [Baris X] [Issue] [Saran fix]
- Contoh: "[Line 45] N+1 query problem — pakai `with()` untuk eager load relasi"
- Jangan cuma bilang "bagus" atau "oke" — kasih actionable feedback

## Token Management
- Warning kalau token mau abis, biar user bisa /finish dulu
- Jangan tiba-tiba mati di tengah-tengah kerja

# NOTES

Proyek Rangkita adalah website landing page & ekosistem digital dengan Laravel 13. Terdapat 19 rute halaman, 6 template undangan, 4 produk, dan 4 artikel SEO. CSS custom sekitar 2083 baris. Database users + quiz (question_packages + questions) aktif (migrate + seed sudah jalan), data produk/template/artikel masih hardcoded di controller.

## Behavior AI (opencode)

- `opencode.json` di root proyek: config yang nge-load `AGENTS.md` + `SUMMARY.md` sebagai instructions + mengatur model per agent (plan = `opencode/big-pickle`, build = `opencode/big-pickle`, reasoning = `opencode/nemotron-3-ultra-free`). DeepSeek & Mimo retired dari provider — deepseek-v4-flash-free gak available lagi, jadi build dipindah ke big-pickle.
- `.opencode/agent/review.md`: agent review (primary mode, `opencode/mimo-v2.5-free`) — review code changes sebelum commit + progress tracking (cross-check TODO checkbox di AGENTS.md dengan git diff).
- `AGENTS.md` punya section `# BEHAVIOR RULES` (17 sub-section): Bahasa & Gaya Bicara, Thorough tapi Terstruktur, Konfirmasi + Jelasin, Expert/Professional, Batasan, Kualitas Kerja, Proyek & Git, Komunikasi, Plan vs Build, Problem Decomposition, Root Cause Analysis, Proactive Issue Detection, Ecosystem Awareness, Testing Mindset, Refactoring Instinct, Code Review, Token Management.
- Ganti mode plan ↔ build ↔ review cukup tekan **Tab** atau **Shift+Tab** (dikonfigurasi via `tui.json` — Tab = `agent_cycle`, Shift+Tab = `agent_cycle_reverse`, `prompt.autocomplete.complete` dimatikan dari Tab biar gak konflik).

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
│   ├── migrations/             9 migration (3 default + add_role_to_users_table + 5 quiz cpns)
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── AdminSeeder.php     Akun admin default
│       ├── QuestionPackageSeeder.php  3 paket TIU
│       └── QuestionSeeder.php  100 soal TIU
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
| Migrations | 9 | 3 default + add_role_to_users_table + 5 quiz cpns (2 schema selesai, 3 skeleton) |
| Seeders | 4 | DatabaseSeeder + AdminSeeder + QuestionPackageSeeder + QuestionSeeder |
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
- **Database Aktif**: users table + role + question_packages + questions (100 soal) sudah migrate & seed, data lain masih hardcoded
- **Custom CSS Dominan**: 2083 baris rangkita.css, asset langsung via `asset()`
- **Auth Aktif**: login/register/logout/Google OAuth, role-based access (user/admin)
- **No API**: Hanya web routes

## Teknologi

- Laravel 13.8 / PHP ^8.3 / MySQL (DB "rangkita", aktif setelah migrate)
- `laravel/socialite` ^5.29 untuk Google OAuth
- `midtrans/midtrans-php` ^2.6.2 untuk Snap API pembayaran quiz CPNS
- Pest PHP ^4.7 untuk testing
- Font Instrument Sans (Bunny CDN)

# CHANGELOG

## Ses 22 Agu 2026 (Sesi 2) - Modul 3 Seeder + Config Midtrans Selesai

- **Schema fix batch 1**: FK `package_id` di 4 migration file (questions, quiz_sessions, transactions, user_access) diubah dari `->constrained()` → `->constrained('question_packages')` — Laravel infer `packages` dari column name `package_id`, padahal tabelnya `question_packages`
- **Schema fix batch 2**: `option_e` ditambah nullable + `correct_answer` di-upgrade dari `enum('a','b','c','d')` → `enum('a','b','c','d','e')` — CPNS 4 opsi, Polri bisa 5 opsi
- **Config Midtrans**: `config/midtrans.php` dibuat (server_key, client_key, is_production), `.env` + `.env.example` diupdate dengan sandbox keys (`Mid-server-*`, `Mid-client-*` format baru, bukan `SB-Mid-*` lama). Keys verified via live API test
- **Seeder 1 — QuestionPackageSeeder**: 3 paket TIU: Verbal (30 soal, gratis), Numerik (50 soal, Rp15.000), Penalaran (20 soal, gratis)
- **Seeder 2 — QuestionSeeder**: 100 soal TIU diekstrak dari PDF KCD (`Soal_KECERDASAN MINGGUAN_KCD-M-2627-8 (1).pdf`, 26 halaman) via `pdftotext`. Termasuk:
  - 30 verbal: definisi kata (BAROMETER, KWARTIR), antonim/sinonim, analogi, klasifikasi, odd-one-out, baris deret
  - 50 numerik: pola bilangan, operasi hitung, cerita (kecepatan, luas, usia, aritmetika sosial, campuran)
  - 20 penalaran: silogisme, logika kondisional, urutan, kesimpulan teks, kode numerik
  - Setiap soal punya: jawaban benar + penjelasan (explanation) + difficulty sedang
- **Bug fix — compact()**: `compact()` di method `q()` gak dipake — Laravel `DB::table()->insert()` sort columns alphabetically, bikin values scramble. Diganti explicit associative array
- **Bug fix — extra null arg**: Semua 100 panggilan `q()` punya argumen `null` extra sebelum correct_answer, bikin parameter shift. Fix massal via regex replace `,null,` → `,`
- **UTF-8 BOM**: File `QuestionSeeder.php` awalnya punya BOM (3 bytes `\xEF\xBB\xBF`), PHP parse error. Fix: rewrite tanpa BOM
- **MySQL**: Laragon MySQL 8.0.30 harus di-start manual (bukan service), `mysqld.exe` langsung via `C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqld.exe --defaults-file=...`
- **Verifikasi**: `php artisan migrate:fresh --seed` sukses — 9 migration + 3 seeders (AdminSeeder + QuestionPackageSeeder + QuestionSeeder). DB check: 3 packages, 100 questions, data valid (correct_answer, difficulty, option_a-e semua terisi)
- **Next**: batch 2 schema skeleton (quiz_sessions, transactions, user_access) → CpnsController + PaymentController → views

## Ses 22 Agu 2026 - Modul 3 Quiz CPNS Dimulai + Agent Model Switch

- **Agent model switch** (commit `5c5552f`): build agent `opencode/deepseek-v4-flash-free` gak available lagi di provider opencode → diganti ke `opencode/big-pickle`. Referensi model di AGENTS.md & SUMMARY.md disinkronin. Ternyata Auth System udah ke-commit sebelumnya (`9b02a59`) — memory "belum di-commit" outdated, dikoreksi
- **Modul 3 Step 1 selesai** (build mode mentoring — user jalankan sendiri): `composer require midtrans/midtrans-php` v2.6.2 (official SDK Snap API)
- **Step 2 selesai**: generate 5 migration via `php artisan make:migration --create` (user jalankan) — question_packages → questions → quiz_sessions → transactions → user_access (urutan timestamp = urutan dependency FK)
- **Step 3 batch 1 selesai**: schema terisi untuk `question_packages` (enum category twk/tiu/tkp, slug unique, price unsignedInteger Rupiah default(0)=gratis, is_active boolean default true) + `questions` (`foreignId('package_id')->constrained()->cascadeOnDelete()`, option_a-d string, enum correct_answer a/b/c/d, explanation nullable)
- **Batch 2 pending**: quiz_sessions + transactions + user_access masih skeleton
- **Commit + Push**: `6bc1922` feat: quiz cpns setup - midtrans sdk + 5 table migrations (7 file, +216 baris) ke origin/main
- **Next**: batch 2 schema → migrate → config/midtrans.php + .env keys → seeder (9 paket + ~135 soal) → CpnsController + PaymentController → views

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

- **Behavior rules di `AGENTS.md` diupgrade dari 10 → 17 sub-section** (persona AI jadi senior full-stack dev), commit `0c44acd`
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
- **Memori files diupdate**: referensi behavior rules `AGENTS.md` & `SUMMARY.md` disinkronin ke "17 sub-section" + daftar section baru
- **Push**: `0c44acd` ke `origin/main` (worktree bersih)

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
  - `README.md` direvisi, `navbar.blade.php` diupdate, `template-preview.blade.php` +359/-. baris (countdown grid, gallery, lokasi, form wish fungsional via JS), `rangkita.css` +226 baris (WISH FORM + CINEMATIC INVITATION OPENING)
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
- **Temuan keybind Tab**: ganti mode plan → build udah default via tombol **Tab** (`agent_cycle`), reverse `Shift+Tab`. Bisa dikustom lewat `tui.json` tapi tidak perlu.
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

- HEAD: `6bc1922` (branch `main`) — pushed ke origin/main, worktree bersih
- **Modul 3 Quiz CPNS + Midtrans IN PROGRESS**: SDK midtrans v2.6.2 terinstall, 5 migration dibuat, schema 2/5 selesai (question_packages + questions), config midtrans terisi, seeder 3 paket + 100 soal TIU terisi
- **Auth System SELESAI 9/9 step** dan sudah committed (`9b02a59`) — migrate + seed + test flow sukses
- **Bug Fixing SELESAI 18/18** (commit `921b851`, `cadb15c`, `c738b4e`)
- Agent model: plan/build = `opencode/big-pickle`, reasoning = `opencode/nemotron-3-ultra-free`, review agent = `mimo-v2.5-free` (commit `5c5552f`)
- DB `rangkita` aktif: users table + role + question_packages + questions (100 soal) — sudah di-migrate & seed
- Google Login: `GOOGLE_CLIENT_ID/SECRET` di `.env` masih kosong — tinggal diisi dari Google Cloud Console
- Midtrans: config/midtrans.php + .env keys terisi (sandbox), SDK v2.6.2 terinstall
- Deploy workflow aktif: user bilang "deploy" → opencode commit+push lokal → user copy-paste command server (Scenario A/B/C sesuai file yang berubah)
- `tui.json` aktif: Tab = ganti agent, Shift+Tab = reverse, autocomplete dimatikan dari Tab
- **Lanjutan Modul 3**: batch 2 schema (quiz_sessions, transactions, user_access) → CpnsController + PaymentController → views


# STYLE

Jawab dalam bahasa Indonesia


