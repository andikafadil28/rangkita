# SUMMARY — Ringkasan Cepat

> **Single source of truth = `AGENTS.md`** (TODO detail, notes teknis, behavior rules, changelog).
> Riwayat sesi lama: `docs/CHANGELOG-archive.md`.
> File ini sengaja tipis buat hemat token tiap sesi — jangan nambah-nambah detail di sini, taruh di AGENTS.md.

# CURRENT

Fokus aktif: **Verifikasi akhir Modul 3** (Step A: quiz Numerik 50 soal dua mode pakai admin; Step B: flow "Lanjut Bayar" token lama pakai akun baru) — nunggu test manual user. Lanjutan: **Modul 6 Admin Panel Kelola Soal** → Modul 4 Undangan → Modul 5 Artikel. Detail lengkap: AGENTS.md.

# Status Modul

| Modul | Status |
|-------|--------|
| 1. Bug Fixing (18 issues) | ✅ SELESAI (`359eb40`, `921b851`, `cadb15c`) |
| 2. Auth System | ✅ SELESAI 9/9 (`9b02a59`) |
| 3. Quiz SOAL + Midtrans | 🔶 Backend+views done, tinggal verifikasi akhir Step A/B |
| 6. Admin Panel Kelola Soal | ⭐ Prioritas berikutnya (~2.5 jam, zero migration) |
| 4. Database Undangan | ⏳ Menunggu (~3 jam) |
| 5. Database Artikel | ⏳ Menunggu (~3.5 jam) |

# Teknologi Singkat

- Laravel 13.8 / PHP ^8.3 / MySQL DB `rangkita` (Laragon, sering mati — start manual via mysqld.exe)
- Auth manual + Socialite (Google OAuth), role user/admin
- midtrans-php v2.6.2 (sandbox keys terisi di .env)
- CSS custom `rangkita.css` ~2546 baris, TANPA Vite/Tailwind; font Instrument Sans via Bunny CDN
- 26 rute web, 5 controller, 6 model, 9 migration ran, Pest PHP untuk testing

# Changelog Terbaru

- **24 Agu 2026 (Sesi 2)**: fix `payment_type` NULL (`e9d34c2` — syncWithMidtrans return Transaction + persist sekali tempat); plan Modul 6; agent vision baru `.opencode/agent/build-complex.md` (muse-spark, image/audio/PDF) karena big-pickle text-only — belum di-commit, wajib restart opencode.
- **24 Agu 2026**: rename CPNS → SOAL penuh (`ff5e41f`); 6 views soal-* + CSS (+801 baris, `f633449`); sandbox test flow OK + 4 bug fix payment (`b0dcc29`).
- Riwayat lengkap sesi 4–22 Agu: `docs/CHANGELOG-archive.md`
