# SUMMARY — Ringkasan Cepat

> **Single source of truth = `AGENTS.md`** (TODO detail, notes teknis, behavior rules, changelog).
> Riwayat sesi lama: `docs/CHANGELOG-archive.md`.
> File ini sengaja tipis buat hemat token tiap sesi — jangan nambah-nambah detail di sini, taruh di AGENTS.md.

# CURRENT

Fokus aktif: **Modul 3 + Modul 6 SELESAI + Dynamic Scoring System**. Sesi 26 Agu 2026: sistem poin dinamis per-paket + per-soal (point_correct, point_blank, point_wrong — nullable, negatif OK), dual display (poin mentah + persentase), backward compatible. Lanjutan: **Modul 4 Database Undangan** → Modul 5 Artikel. Detail lengkap: AGENTS.md.

# Status Modul

| Modul | Status |
|-------|--------|
| 1. Bug Fixing (18 issues) | ✅ SELESAI (`359eb40`, `921b851`, `cadb15c`) |
| 2. Auth System | ✅ SELESAI 9/9 (`9b02a59`) |
| 3. Quiz SOAL + Midtrans | ✅ SELESAI |
| 6. Admin Panel Kelola Soal | ✅ SELESAI (25 Agu 2026) |
| 6b. Dynamic Scoring System | ✅ SELESAI (26 Agu 2026) |
| 4. Database Undangan | ⏳ Menunggu (~3 jam) |
| 5. Database Artikel | ⏳ Menunggu (~3.5 jam) |

# Teknologi Singkat

- Laravel 13.8 / PHP ^8.3 / MySQL DB `rangkita` (Laragon, sering mati — start manual via mysqld.exe)
- Auth manual + Socialite (Google OAuth), role user/admin
- midtrans-php v2.6.2 (sandbox keys terisi di .env)
- CSS custom `rangkita.css` ~3050 baris, TANPA Vite/Tailwind; font Instrument Sans via Bunny CDN
- 45 rute web, 8 controller, 7 model, 12 migration ran, Pest PHP untuk testing

# Changelog Terbaru

- **26 Agu 2026**: Dynamic Per-Question Scoring System — 2 migrations (12 total), per-package + per-question point overrides (nullable = inherit), dual display (poin mentah + persentase), backward compatible. Bug fix: negative score clamp (`max(0, ...)`). 8 views updated, ~50 baris CSS baru.
- **25 Agu 2026 (Sesi 2)**: Layout fix (icon TWK, equal-height cards, badge) + Riwayat Quiz (`/soal/riwayat` + dashboard stats 3 box + recent 3) + Auth-aware navbar (Masuk/Daftar vs Dashboard/Keluar) + fix bug `$package->category` → `$package->soalCategory`. Commit `f66e8ec`. Routes 44→45, Views 35→36, CSS ~2874→~3100.
- **25 Agu 2026 (Sesi 1)**: Modul 3 verifikasi akhir SELESAI (Step A+B lolos) → Modul 6 Admin Panel Kelola Soal SELESAI (3 controller, 19 rute admin, 14 views, kategori dinamis via `soal_categories` table + enum→FK migration). Bug fixes: `transactions()` missing → 500 hapus paket, `Route::resource->parameters()` gak jalan di Laravel 13, button alignment. Deploy server verified (`e69d84f`).
- **24 Agu 2026 (Sesi 2+3)**: fix `payment_type` NULL (`e9d34c2`); memory files compress -67% (`befab6d`); rename CPNS → SOAL (`ff5e41f`); 4 bug fix payment (`b0dcc29`); agent vision `build-complex.md`.
- Riwayat lengkap sesi 4–22 Agu: `docs/CHANGELOG-archive.md`
