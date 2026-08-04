# CURRENT

Fokus aktif: pengembangan template undangan. 6 template berbagi satu Blade yang sama, dibedakan hanya via `theme_class` CSS. Analisis sistem template selesai, TODO baru sudah disusun.

# TODO

## Template Undangan (Fokus Utama)

- [ ] High: Pisahkan Blade/CSS per template biar tiap tema bisa custom
- [ ] High: Fix link detail page di listing (ke `/undangan/template/{slug}`)
- [ ] Medium: Rapikan CSS - kurangi duplikasi (cek ulang setelah pull, blok V1.6 override sudah tidak dipakai)
- [ ] Medium: Ganti gallery placeholder dengan gambar beneran
- [ ] Low: Buat form ucapan (wish) fungsional
- [ ] Low: Perbaiki Google Maps URL yang masih `#`

## Backend

- [ ] Low: Database migration untuk data produk & template

# NOTES

Proyek Rangkita adalah website landing page & ekosistem digital dengan Laravel 13. Terdapat 10 rute halaman, 6 template undangan, 4 produk, dan 4 artikel SEO. CSS custom sekitar 2083 baris. Belum ada database migration, semua data masih hardcoded di controller.

## Behavior AI (opencode)

- `opencode.json` di root proyek: config yang nge-load `AGENTS.md` sebagai instructions + mengatur model per agent (plan = `opencode/mimo-v2.5-free`, build = `opencode/deepseek-v4-flash-free`).
- `AGENTS.md` punya section `# BEHAVIOR RULES` (8 sub-section): Bahasa & Gaya Bicara (gen-z, Bahasa Indonesia), Simpel & Gak Ribet, Konfirmasi + Jelasin, Mentor/Guru, Batasan, Kualitas Kerja, Proyek & Git, Komunikasi.
- Ganti mode plan ↔ build cukup tekan **Tab** atau **Shift+Tab** (dikonfigurasi via `tui.json` — Tab = `agent_cycle`, Shift+Tab = `agent_cycle_reverse`, `prompt.autocomplete.complete` dimatikan dari Tab biar gak konflik).

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
│   ├── css/app.css             Import Tailwind CSS 4 (9 baris)
│   ├── js/app.js               Kosong (placeholder)
│   └── views/
│       ├── landing.blade.php   Homepage utama (206 baris)
│       ├── landing1.blade.php  Versi alternatif (379 baris, CSS inline)
│       ├── welcome.blade.php   Welcome bawaan Laravel (tidak dipakai)
│       ├── components/navbar.blade.php
│       ├── layouts/app.blade.php   Layout utama (26 baris)
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
├── node_modules/ + vendor/     Dependencies
└── file config root: .env, composer.json, package.json, vite.config.js, opencode.json, tui.json
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
- **Custom CSS Dominan**: 2083 baris rangkita.css, bukan via Vite pipeline
- **No Auth**: Tidak ada autentikasi/admin panel
- **No API**: Hanya web routes

## Teknologi

- Laravel 13.8 / PHP ^8.3 / MySQL (DB "rangkita", belum aktif)
- Tailwind CSS 4 + Vite 8 (untuk welcome page saja)
- Pest PHP ^4.7 untuk testing
- Font Instrument Sans (Bunny CDN)

# CHANGELOG

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
- **`AGENTS.md`**: Tambah section `# BEHAVIOR RULES` berisi 8 sub-section (Bahasa & Gaya Bicara, Simpel & Gak Ribet, Konfirmasi + Jelasin, Mentor/Guru, Batasan, Kualitas Kerja, Proyek & Git, Komunikasi).
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

## Status Sekarang

- HEAD: `5a7d32b` (branch `main`, up to date dengan `origin/main`)
- Worktree bersih - semua perubahan sesi sudah di-commit & push
- CSS custom: 2083 baris (setelah pull, blok V1.6 override tidak dipakai)
- Deploy workflow aktif: user bilang "deploy" → opencode commit+push lokal → user copy-paste command server (Scenario A/B/C sesuai file yang berubah)
- `tui.json` aktif: Tab = ganti agent, Shift+Tab = reverse, autocomplete dimatikan dari Tab

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
