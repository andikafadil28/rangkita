# Modul 4 Database Undangan

Status: SELESAI diimplementasikan dan diverifikasi pada 4 September 2026; belum commit/deploy.

Estimasi: 4,5-5,5 jam.

Dokumen ini menjadi sumber detail implementasi Modul 4. `AGENTS.md` dan
`SUMMARY.md` hanya menyimpan status serta keputusan inti agar konteks otomatis
tetap ringan.

## Kondisi Awal

- Enam template masih berupa array dari `PageController::getWeddingTemplates()`.
- Data pasangan dan acara masih dari `PageController::getDummyWeddingData()`.
- Route marketing yang aktif: `/undangan`, `/undangan/template/{slug}`, dan
  `/undangan/preview/{slug}`.
- Galeri preview masih placeholder teks.
- Form ucapan hanya menambah elemen ke DOM dan belum menyimpan data.
- Semua template memakai satu Blade dan animasi opening generik yang sama.
- Belum ada CRUD admin maupun URL undangan pelanggan `/undangan/{slug}`.

## Hasil yang Ditargetkan

1. Template, wedding, galeri, dan ucapan bersumber dari database.
2. Admin dapat membuat, mengedit, memublikasikan, dan menghapus undangan.
3. Admin dapat upload, mengurutkan, memberi caption, dan menghapus foto.
4. Wedding published tersedia melalui `/undangan/{slug}`.
5. Wedding draft hanya dapat dilihat admin; pengunjung menerima 404.
6. Ucapan tamu tersimpan permanen dan langsung tampil.
7. Admin dapat menyembunyikan, menampilkan kembali, dan menghapus ucapan.
8. Preview marketing dan enam theme existing tetap bekerja.
9. Setiap template mempunyai opening dan scroll animation yang khas.
10. Asset demo gratis disimpan lokal, dioptimasi, dan sumbernya tercatat.

## Keputusan Final

- Ucapan baru langsung disimpan dengan `is_approved = true`.
- Endpoint ucapan tetap memakai CSRF, validasi, dan rate limiting.
- Events disimpan sebagai JSON pada `weddings.events`.
- Blok akad wajib; blok resepsi optional.
- Foto dikelola sebagai upload sungguhan melalui disk `public`.
- Slug dibuat otomatis saat create dan stabil saat nama pasangan diedit.
- Template dikelola oleh seeder; template CRUD bukan scope modul ini.
- Keenam template memakai shared Blade dengan motion profile berbeda.
- Level animasi balanced cinematic, dipicu saat opening dan scroll.
- Tidak memakai GSAP atau dependency frontend baru.
- Asset internet diunduh ke repo; production tidak melakukan hotlink.

## Non-Goal

- Customer self-service untuk membuat undangan.
- Pembayaran produk undangan.
- RSVP kehadiran.
- Background music upload.
- Template builder atau CRUD template.
- Custom domain.
- Statistik pengunjung.
- Crop atau image editor interaktif.

## Schema Database

### `templates`

| Kolom | Tipe | Catatan |
|---|---|---|
| id | bigint | Primary key |
| slug | string unique | Route key stabil |
| name | string | Nama template |
| style | string | Label gaya |
| theme_class | string | Selector CSS, contoh `theme-elegant` |
| description | text | Deskripsi marketing |
| features | json | Daftar fitur |
| icon | string nullable | Ikon template |
| timestamps | timestamps | Audit dasar |

### `weddings`

| Kolom | Tipe | Catatan |
|---|---|---|
| id | bigint | Primary key |
| template_id | foreignId | Relasi ke templates, restrict delete |
| slug | string unique | URL publik |
| groom_short_name | string | Nama pendek mempelai pria |
| groom_full_name | string | Nama lengkap mempelai pria |
| groom_parent | string nullable | Keterangan orang tua |
| bride_short_name | string | Nama pendek mempelai wanita |
| bride_full_name | string | Nama lengkap mempelai wanita |
| bride_parent | string nullable | Keterangan orang tua |
| wedding_date | dateTime | Countdown dan tanggal utama |
| events | json | Detail akad dan resepsi |
| maps_url | text nullable | URL Google Maps |
| status | enum | `draft` atau `published`, default `draft` |
| timestamps | timestamps | Audit dasar |

Format events:

```json
{
  "akad": {
    "title": "Akad Nikah",
    "date": "2028-05-12",
    "time": "08:00",
    "place": "Gedung Serbaguna",
    "address": "Jl. Contoh No. 123"
  },
  "resepsi": {
    "title": "Resepsi",
    "date": "2028-05-12",
    "time": "11:00",
    "place": "Gedung Serbaguna",
    "address": "Jl. Contoh No. 123"
  }
}
```

### `wedding_gallery`

| Kolom | Tipe | Catatan |
|---|---|---|
| id | bigint | Primary key |
| wedding_id | foreignId | Cascade delete |
| photo_path | string | Path relatif disk `public` |
| caption | string nullable | Alt text dan caption |
| sort_order | unsignedInteger | Urutan tampil |
| timestamps | timestamps | Audit dasar |

Nama tabel mengikuti scope awal proyek. Model `WeddingGallery` perlu
`protected $table = 'wedding_gallery'` karena nama tabel tidak mengikuti plural
convention Eloquent.

### `wedding_wishes`

| Kolom | Tipe | Catatan |
|---|---|---|
| id | bigint | Primary key |
| wedding_id | foreignId | Cascade delete |
| guest_name | string | Nama tamu |
| message | text | Ucapan, maksimal 300 karakter |
| is_approved | boolean | Default true |
| timestamps | timestamps | Waktu kirim |

## Model dan Relationship

File baru:

- `app/Models/Template.php`
- `app/Models/Wedding.php`
- `app/Models/WeddingGallery.php`
- `app/Models/WeddingWish.php`

Relationship:

- `Template::weddings()` has many Wedding.
- `Wedding::template()` belongs to Template.
- `Wedding::gallery()` has many WeddingGallery ordered by `sort_order`.
- `Wedding::wishes()` has many WeddingWish.
- `Wedding::approvedWishes()` hanya mengambil wish visible.
- `WeddingGallery::wedding()` belongs to Wedding.
- `WeddingWish::wedding()` belongs to Wedding.

Cast:

- `Template.features` menjadi array.
- `Wedding.events` menjadi array.
- `Wedding.wedding_date` menjadi datetime.
- `WeddingWish.is_approved` menjadi boolean.

`Template` dan `Wedding` menggunakan slug route binding melalui
`getRouteKeyName()`.

## Seeder

File baru:

- `database/seeders/TemplateSeeder.php`
- `database/seeders/WeddingSeeder.php`

`TemplateSeeder` memindahkan enam template existing: Elegant, Minimalis,
Floral, Modern, Classic, dan Royal. `WeddingSeeder` memindahkan data demo Dika
dan Nur. Sebelum membuat row gallery, `WeddingSeeder` menyalin source image dari
`public/images/wedding/demo-gallery/` ke disk `public/weddings/demo/` jika file
belum tersedia. Dengan begitu row demo dan upload admin memakai format
`photo_path` yang sama. Seeder memakai `updateOrCreate()` agar aman dijalankan
ulang.

Pada database existing, jalankan seeder secara spesifik. Hindari full
`DatabaseSeeder` saat deploy karena seeder utama juga membuat akun test.

## Controller Publik

Buat `app/Http/Controllers/WeddingController.php` dengan method:

- `index()` untuk listing template dari database.
- `templateDetail(Template $template)` untuk halaman detail marketing.
- `templatePreview(Template $template)` untuk preview dengan wedding demo.
- `show(Wedding $wedding)` untuk undangan pelanggan.
- `addWish(Request $request, Wedding $wedding)` untuk menyimpan ucapan.

Method dan array undangan di `PageController` dihapus setelah route berpindah.
Ini memindahkan ownership domain dan mengurangi God Class.

Query public wajib eager-load template, gallery, dan maksimal 50 approved
wishes terbaru. Blade tetap memakai escaped echo `{{ }}` untuk mencegah stored
XSS.

Wedding draft menghasilkan 404 untuk guest. Admin terautentikasi boleh membuka
URL yang sama untuk preview sebelum publish.

## Controller Admin

Buat `app/Http/Controllers/AdminWeddingController.php` dengan method:

- `index()`
- `create()`
- `store()`
- `edit()`
- `update()`
- `destroy()`
- `destroyGalleryPhoto()`
- `toggleWish()`
- `destroyWish()`

Index memakai eager loading dan `withCount()` untuk mencegah N+1. Nested
gallery dan wish harus diverifikasi benar-benar milik wedding pada URL agar
tidak terkena IDOR.

Slug create menggunakan nama pendek pasangan dan suffix jika bentrok:

```text
dika-nur
dika-nur-2
dika-nur-3
```

Slug tidak diregenerasi otomatis saat update karena link mungkin sudah
disebarkan.

## Validasi

- Template wajib ada.
- Nama pendek dan lengkap wajib, bertipe string, dan memiliki batas panjang.
- `wedding_date` wajib berupa tanggal valid.
- Event akad wajib lengkap.
- Event resepsi boleh kosong; jika mulai diisi, field utamanya wajib valid.
- `maps_url` harus URL jika diisi.
- Status hanya `draft` atau `published`.
- Galeri berupa array dengan batas jumlah per request.
- File hanya JPG, JPEG, PNG, atau WebP dengan batas ukuran.
- Nama tamu 2-50 karakter.
- Pesan tamu 10-300 karakter.

## Upload dan Cleanup

Foto pelanggan disimpan di:

```text
storage/app/public/weddings/{wedding-id}/
```

URL publik menggunakan `Storage::url()` atau `asset('storage/...')`. File baru
dibersihkan jika transaksi database gagal. File lama baru dihapus setelah
perubahan database berhasil. Menghapus wedding ikut membersihkan foldernya.
Request tidak boleh menerima path storage mentah sebagai sumber kebenaran.

Production harus mempunyai symlink dari `php artisan storage:link`.

## Route

Route marketing/public:

```text
GET  /undangan
GET  /undangan/template/{template}
GET  /undangan/preview/{template}
GET  /undangan/{wedding}
POST /undangan/{wedding}/ucapan
```

Route `/undangan/{wedding}` harus dideklarasikan setelah route statis
`template` dan `preview`. Endpoint ucapan memakai rate limiter, target awal
`throttle:5,1`.

Route admin di dalam middleware `auth` dan `admin`:

```text
GET    /admin/undangan
GET    /admin/undangan/create
POST   /admin/undangan
GET    /admin/undangan/{wedding}/edit
PUT    /admin/undangan/{wedding}
DELETE /admin/undangan/{wedding}
DELETE /admin/undangan/{wedding}/galeri/{gallery}
PATCH  /admin/undangan/{wedding}/ucapan/{wish}
DELETE /admin/undangan/{wedding}/ucapan/{wish}
```

## View Admin

File baru:

- `resources/views/admin/weddings/index.blade.php`
- `resources/views/admin/weddings/create.blade.php`
- `resources/views/admin/weddings/edit.blade.php`
- `resources/views/admin/weddings/_form.blade.php`

Form mencakup template, data pasangan, tanggal utama, akad, resepsi optional,
Maps URL, status, dan multiple gallery upload. Edit menampilkan foto existing,
caption, urutan, serta daftar wish dengan aksi hide/show/delete.

Admin navbar dan quick link dashboard diaktifkan ke `admin.weddings.index`.

## View Publik

File baru:

- `resources/views/pages/undangan-public.blade.php`

File existing yang diperbarui:

- `resources/views/pages/undangan.blade.php`
- `resources/views/pages/template-detail.blade.php`
- `resources/views/pages/template-preview.blade.php`

Preview marketing dan public wedding memakai shared invitation markup. Galeri
placeholder diganti `<img>` asli, countdown membaca `wedding_date`, dan events
membaca JSON. Form wish mempunyai POST fallback dan enhancement JavaScript agar
ucapan dapat ditambahkan tanpa reload penuh.

## Motion System

Animasi berlaku pada preview marketing dan undangan pelanggan. Listing card dan
admin panel tidak memerlukan cinematic animation.

Buat `public/js/wedding-invitation.js` untuk:

- Membuka cover.
- Menjalankan countdown.
- Mengamati section dengan satu `IntersectionObserver`.
- Menambahkan class `.is-revealed` satu kali.
- Menjalankan stagger pada card.
- Membuat dekorasi ringan sesuai theme.
- Mengirim wish ke backend dan memperbarui DOM setelah respons sukses.
- Menghormati `prefers-reduced-motion`.

Shared markup memakai hook seperti:

```html
<section class="invitation-section" data-reveal>
```

Konten default tetap terlihat. JavaScript menambahkan `.motion-ready`; hanya
konten di bawah class tersebut yang disembunyikan sebelum reveal. Dengan pola
progressive enhancement ini, kegagalan JavaScript tidak menghilangkan konten.

### Profil Template

| Template | Motion profile |
|---|---|
| Elegant | Slow fade-up, soft zoom, dan shimmer keemasan |
| Minimalis | Clean fade, line wipe, cepat dan tenang |
| Floral | Bloom reveal, kelopak melayang, dan soft scale |
| Modern | Alternating slide, gradient orb, transisi tegas |
| Classic | Curtain/page reveal dan ornamental border draw |
| Royal | Dramatic zoom, gold glow, sparkle, staggered cards |

Performance guard:

- Utamakan `transform` dan `opacity`.
- Hindari animasi layout seperti `width`, `height`, `top`, dan `left`.
- Reveal hanya sekali.
- Dekorasi dibatasi sekitar 8-12 elemen dan dikurangi di mobile.
- Galeri memakai `loading="lazy"`.
- Tidak ada dependency animasi baru.
- Reduced-motion langsung menampilkan seluruh konten.

## Asset Gratis

Foto demo boleh berasal dari Unsplash atau Pexels dengan lisensi penggunaan
gratis yang diverifikasi saat download. File tidak di-hotlink.

Struktur:

```text
public/images/wedding/
|-- elegant/
|-- minimalis/
|-- floral/
|-- modern/
|-- classic/
|-- royal/
`-- demo-gallery/
```

Rencana asset:

- Satu hero/background khas per template.
- Empat sampai enam foto wedding untuk galeri demo.
- Dekorasi tambahan dibuat dengan CSS atau SVG buatan sendiri.
- Raster image dikonversi ke WebP dan dikompres.
- Source galeri demo di repo disalin secara idempotent oleh `WeddingSeeder` ke
  disk `public`; public view tetap membaca seluruh gallery melalui relationship.
- Sumber, URL, author, dan jenis lisensi dicatat di
  `docs/ASSET-LICENSES.md`.

Asset ini hanya untuk preview/demo. Foto pelanggan tetap berasal dari upload
admin dan berada di storage.

## Security dan Integrity

- Seluruh admin route dilindungi `auth` dan `admin` middleware.
- Public wish memakai CSRF dan rate limiting.
- Semua output tamu di-escape oleh Blade.
- Draft tidak bocor ke guest.
- Nested resource ownership diverifikasi untuk mencegah IDOR.
- MIME, extension, size, dan jumlah upload divalidasi.
- Nama file dibuat oleh aplikasi, bukan memakai nama request mentah.
- FK cascade dipakai untuk data anak, sedangkan file storage dibersihkan oleh
  aplikasi.

## Test Case

- Guest dapat membuka wedding published.
- Guest mendapat 404 untuk wedding draft.
- Admin dapat preview draft.
- Guest dan user biasa tidak dapat mengakses CRUD admin.
- Admin dapat create, update, publish, dan delete wedding.
- Slug collision menghasilkan suffix dan slug tetap stabil saat update.
- Upload valid tersimpan; file invalid ditolak.
- Menghapus gallery atau wedding membersihkan file.
- Wish valid tersimpan dengan `is_approved = true` dan langsung terlihat.
- Wish invalid ditolak.
- Rate limiter wish bekerja.
- Gallery/wish dari wedding lain tidak dapat diubah melalui nested route.
- Enam template tetap dapat dibuka dengan motion profile masing-masing.
- Reduced-motion dan no-JavaScript fallback tetap menampilkan konten.

## Verifikasi

```bash
php artisan migrate
php artisan db:seed --class=TemplateSeeder
php artisan db:seed --class=WeddingSeeder
php artisan storage:link
php artisan test --filter=Wedding
php artisan route:list --path=undangan
php artisan view:cache
php artisan optimize:clear
```

Smoke test:

```text
/undangan
/undangan/template/elegant
/undangan/preview/elegant
/undangan/dika-nur
/admin/undangan
```

Deploy server memakai `sudo php artisan optimize:clear` karena user SSH tidak
memiliki write access ke `bootstrap/cache/`.

## Stop Condition

Stop ketika seluruh acceptance utama, test terfokus, route check, Blade compile,
dan smoke test lulus. Jangan menambah RSVP, musik, pembayaran undangan, template
builder, atau fitur artikel dalam modul ini.

## Hasil Verifikasi

- Full suite: 24 test dan 134 assertions lulus pada MySQL `rangkita_testing`.
- Migration fresh, seeding idempotent dua kali, rollback empat migration Modul 4, lalu migrate ulang berhasil.
- Pint, PHP lint, Blade cache, syntax check JavaScript, route inventory, dan pemeriksaan asset WebP lulus.
- HTTP smoke untuk listing, detail template, preview, wedding published, admin redirect, dan CSRF 419 lulus.
- Independent review tidak menemukan issue critical/high; hardening slug race, kegagalan copy seeder, dan observability cleanup sudah diterapkan.
