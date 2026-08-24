# CHANGELOG ARSIUP - Rangkita

Riwayat sesi 4-22 Agustus 2026 (diarsip dari AGENTS.md tanggal 24 Agu 2026 buat hemat token sesi). Entry terbaru tetap di AGENTS.md.

---

## Ses 22 Agu 2026 (Sesi 3) - Modul 3 Backend Selesai: Models + Controllers + Routes

- **Koreksi memory**: Batch 2 schema ternyata UDAH selesai sebelum sesi — 5/5 migration terisi lengkap + 9/9 status Ran (user kerjain sendiri setelah sesi 2 tutup, TODO belum dicentang). Diverifikasi via `migrate:status` + baca file
- **Step 2 Models (5 file baru + 1 edit)**:
  - `QuestionPackage.php`: casts is_active, `getRouteKeyName() = 'slug'`, relasi questions/quizSessions/userAccess, helper `isFree()`
  - `Question.php`, `QuizSession.php` (casts answers array), `Transaction.php`, `UserAccess.php` ($table eksplisit)
  - `User.php`: +3 relasi balik (quizSessions, transactions, userAccess) + import HasMany
- **Bug fix — FK inference**: Eloquent cari kolom `question_package_id` (dari nama class QuestionPackage), padahal kolom asli `package_id` → error "Unknown column". Fix: FK eksplisit `'package_id'` di SEMUA relasi ke QuestionPackage (6 titik: questions, quizSessions, userAccess di package; package di question/quizSession/transaction/userAccess)
- **Schema change**: Kolom `access_granted` di-drop dari migration user_access (keputusan user: "yang paling recomen") — redundant karena keberadaan row = punya akses. Edit migration lama aman karena dev stage + langsung fresh ulang
- **Bug fix data seeder**: TIU Numerik price 0 → 15000 (harusnya paket berbayar untuk test Midtrans). Ketahuan pas verifikasi tinker: `where('price','>',0)->first()` return null
- **Verifikasi models**: `migrate:fresh --seed` sukses, script test bootstrap Laravel: count questions verbal=30, isFree() benar per paket, routeKey="tiu-verbal" (slug binding aktif), UserAccess::count() tanpa error table not found, casts JSON answers works
- **Commit**: `cb6c271` feat(cpns): models + batch 2 schema + seeders (17 file, +550/-80) — include warisan sesi 2 yang belum ke-commit (schema batch 2, seeder, config midtrans). Audit secrets dulu: config/midtrans.php pakai env(), .env.example cuma placeholder kosong. Belum push
- **Step 3 Controllers**: `CpnsController.php` baru:
  - index: packages groupBy category; category: validasi twk/tiu/tkp → abort 404 kalau invalid
  - quiz: gate akses (berbayar + tanpa row user_access → redirect payment.create), mode latihan/test dari query param, time_limit test = jumlah_soal × 54 detik (konstanta SECONDS_PER_QUESTION)
  - submit: validasi answers array (in:a-e), skor dihitung SERVER-SIDE vs pluck correct_answer, simpan QuizSession, redirect result
  - result: authorization check `session->user_id === auth()->id()` → abort 403, rekap collection per soal (user_answer, is_correct, is_skipped)
  - SECURITY: query soal select eksplisit TANPA correct_answer/explanation biar gak bocor ke client
- **Step 3 Controllers**: `PaymentController.php` baru:
  - create: gate isFree/hasAccess → redirect quiz; reuse pending transaction (kalau snap_token ada); else Snap::createTransaction dengan transaction_details/item_details/customer_details; order_id format `RANGKITA-{userId}-{ymdHis}-{Str::upper(Str::random(6))}`
  - callback: `new Notification()` (SDK parse php://input), verify signature sha512(order_id+status_code+gross_amount+serverKey) pakai `hash_equals` timing-safe, match status capture/settlement→paid, deny→failed, expire→expired, cancel→cancelled; paid → UserAccess::firstOrCreate (idempotent)
  - success: halaman sukses + lookup transaksi by order_id optional
- **Step 4 Routes** (+8 rute → total 26): grup publik cpns.index/cpns.category; auth cpns.quiz, cpns.submit (POST), cpns.result (/hasil-quiz/{session}), payment.create (/cpns/paket/{package}/beli — binding slug), payment.success (/pembayaran/sukses); webhook POST /payment/callback tanpa auth
- **CSRF exempt**: `$middleware->validateCsrfTokens(except: ['payment/callback'])` di bootstrap/app.php — webhook Midtrans server-to-server gak bawa CSRF token
- **Cleanup**: route `/cpns` PageController@cpns dihapus + method `cpns()` dead dihapus dari PageController (method cuma return view statis)
- **Code smell fixed**: ternary dengan assignment di PaymentController::create diganti if/else biasa
- **Verifikasi controllers/routes**: php -l 5 file clean, `route:list --except-vendor` 26 rute semua ter-bind benar, HTTP smoke test GET /cpns = 200 OK (artisan serve port 8098), view:cache sukses
- **Catatan PowerShell**: `tinker --execute` ribet quoting ($ di-expand PS double-quote, inner quotes hilang) → workaround: script PHP sementara dengan manual bootstrap (`require vendor/autoload.php` + `$app->make(Kernel)->bootstrap()`), hapus setelah pakai
- **Pending Modul 3**: Step 5 Views (cpns.blade update + 5 view baru: cpns-category, cpns-quiz, cpns-result, cpns-payment [popup Snap JS], cpns-payment-success) + Step 6 test flow end-to-end. Halaman quiz/category/result/payment masih 500 karena view belum ada

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
