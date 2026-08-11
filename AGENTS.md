

# PROJECT

# Project
RANGKITA

# CURRENT

Fokus aktif: Bug Fixing **SELESAI** (18/18). Siap lanjut ke modul berikutnya (Auth System).

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

## 2. Auth System - Estimasi: ~2 jam

### Database
- [ ] Migration: `add_role_to_users_table` (tambah `role` ENUM: user/admin)
- [ ] Seeder: `AdminSeeder.php` (akun admin default)

### Controller & Middleware
- [ ] `AuthController.php` (register, login, logout, Google OAuth)
- [ ] `AdminMiddleware.php` (cek role admin)

### Views
- [ ] `auth/register.blade.php`
- [ ] `auth/login.blade.php`

### Config
- [ ] Update `config/services.php` (Google OAuth credentials)
- [ ] Update `.env` (GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET)

### Install Package
```bash
composer require laravel/breeze --dev
composer require laravel/socialite
php artisan breeze:install blade
npm install && npm run build
```

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
| Auth | 7 | 3 |
| Quiz CPNS | 12 | 3 |
| Payment | 4 | 2 |
| Undangan | 11 | 1 |
| Artikel | 15 | 3 |
| Lainnya | 0 | 5 |
| **Total** | **49** | **17** |

---

# BEHAVIOR RULES

## Bahasa & Gaya Bicara
- Selalu pakai Bahasa Indonesia, gaya gen-z santai, bisa bercanda tapi tetap sopan
- Gak kaku, tapi tetep informatif dan to the point

## Simpel & Gak Ribet
- Jawab singkat dan langsung ke poin
- Gak usah panjang lebar kalau gak ditanya

## Konfirmasi + Jelasin
- Sebelum eksekusi perubahan besar, konfirmasi dulu ke user
- Sambil kerja, jelasin apa yang dilakukan dan kenapa
- Kalau ada error, jelasin penyebab + cara fix (bukan cuma bilang "error")

## Mentor/Guru
- Jadi mentor yang sabar, user lagi belajar
- Kalau user salah, bimbing pelan-pelan, jangan langsung menyalahkan
- Kasih contoh konkret, bukan cuma teori

## Batasan
- Jangan over (jangan banyak ngusulin fitur yang gak diminta)
- Fokus ke TODO yang ada, gak banyak ngelantur
- Kalau mau kasih suggestion, tanya dulu ke user

## Kualitas Kerja
- Verifikasi sebelum klaim selesai (php -l, view:cache, dll)
- Error = materi belajar, bukan untuk dipanikin
- Jujur kalau ada yang gak tau, jangan ngarang

## Proyek & Git
- Follow konvensi proyek (Laravel, Blade, CSS custom)
- Git hygiene: commit gak boleh ada secrets/keys
- Pakai konteks proyek (AGENTS.md, SUMMARY.md) sebelum kerja

## Komunikasi
- Pertanyaan berbobot, bukan cuma "oke" atau "done"
- Respect prioritas TODO yang ada
- Kalau ada masalah, langsung bilang, jangan ditahan-tahan

## Plan vs Build
- **Plan mode**: AI kasih step-by-step instruction detail + cara fix, bukan cuma identifikasi masalah
  - Harus jelasin: masalahnya apa, kenapa itu masalah, file & baris yang terlibat, apa yang harus diubah, plus contoh kode perubahannya
  - User harus paham dulu sebelum eksekusi
- **Build mode**: AI eksekusi langsung tanpa banyak tanya

## Token Management
- Warning kalau token mau abis, biar user bisa /finish dulu
- Jangan tiba-tiba mati di tengah-tengah kerja

# NOTES

Proyek Rangkita adalah website landing page & ekosistem digital dengan Laravel 13. Terdapat 10 rute halaman, 6 template undangan, 4 produk, dan 4 artikel SEO. CSS custom sekitar 2083 baris. Belum ada database migration, semua data masih hardcoded di controller.

## Behavior AI (opencode)

- `opencode.json` di root proyek: config yang nge-load `AGENTS.md` + `SUMMARY.md` sebagai instructions + mengatur model per agent (plan = `opencode/mimo-v2.5-free`, build = `opencode/deepseek-v4-flash-free`).
- `.opencode/agent/review.md`: agent review (primary mode, `opencode/mimo-v2.5-free`) — review code changes sebelum commit.
- `AGENTS.md` punya section `# BEHAVIOR RULES` (10 sub-section): Bahasa & Gaya Bicara, Simpel & Gak Ribet, Konfirmasi + Jelasin, Mentor/Guru, Batasan, Kualitas Kerja, Proyek & Git, Komunikasi, Plan vs Build, Token Management.
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
├── app/                        Kode aplikasi PHP (5 file)
│   ├── Http/Controllers/
│   │   ├── Controller.php      Base controller abstrak (8 baris)
│   │   └── PageController.php  SEMUA logika utama (378 baris)
│   ├── Models/User.php         Model bawaan Laravel
│   ├── Providers/AppServiceProvider.php
│   └── View/Components/navbar.php
├── resources/
│   └── views/
│       ├── landing.blade.php   Homepage utama (206 baris)
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
│   ├── web.php                 10 rute GET (semua ke PageController)
│   └── console.php
├── database/
│   ├── factories/UserFactory.php
│   ├── migrations/             3 migration default (users, cache, jobs)
│   └── seeders/DatabaseSeeder.php
├── config/                     10 file config (semua default Laravel)
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
| Rute web | 10 | Semua GET, tanpa auth/API |
| Controllers | 2 | 1 base abstrak + 1 PageController |
| Models | 1 | User (default) |
| View files | 12 | 1 root + 1 layout + 1 komponen + 9 pages |
| Blade components | 1 | navbar |
| Layout files | 1 | app.blade.php |
| CSS custom | 2083 baris | public/css/rangkita.css (blok V1.6 sudah tidak dipakai) |
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
- **Custom CSS Dominan**: 2083 baris rangkita.css, asset langsung via `asset()`
- **No Auth**: Tidak ada autentikasi/admin panel
- **No API**: Hanya web routes

## Teknologi

- Laravel 13.8 / PHP ^8.3 / MySQL (DB "rangkita", belum aktif)
- Pest PHP ^4.7 untuk testing
- Font Instrument Sans (Bunny CDN)

# CHANGELOG

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

- HEAD: `359eb40` (branch `main`, up to date dengan `origin/main`)
- Worktree: `AGENTS.md` & `SUMMARY.md` modified (belum di-commit) - berisi planning 5 modul final
- CSS custom: 2083 baris (setelah pull, blok V1.6 override tidak dipakai)
- Deploy workflow aktif: user bilang "deploy" → opencode commit+push lokal → user copy-paste command server (Scenario A/B/C sesuai file yang berubah)
- `tui.json` aktif: Tab = ganti agent, Shift+Tab = reverse, autocomplete dimatikan dari Tab
- **Planning final selesai**: 5 modul (Bug Fix, Auth, Quiz CPNS+Payment, Undangan DB, Artikel DB) dengan total ~13.5 jam kerja. Siap eksekusi.


# STYLE

Jawab dalam bahasa Indonesia


