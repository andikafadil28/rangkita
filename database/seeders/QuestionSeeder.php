<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    private function q($pkg, $text, $a, $b, $c, $d, $e, $ans, $exp, $diff)
    {
        return [
            'pkg' => $pkg, 'text' => $text,
            'a' => $a, 'b' => $b, 'c' => $c, 'd' => $d, 'e' => $e,
            'ans' => $ans, 'exp' => $exp, 'diff' => $diff,
        ];
    }

    public function run(): void
    {
        $pkgs = DB::table('question_packages')->pluck('id','slug');
        $v = $pkgs['tiu-verbal'];
        $n = $pkgs['tiu-numerik'];
        $p = $pkgs['tiu-penalaran'];

        $rows = [];

// ===== VERBAL 1-10: Sinonim & Antonim =====
$rows[]=$this->q($v,'BAROMETER = ...','Hubugan','Ukuran','Berat','Acuan','Nilai','b','Barometer = baros+metron = alat ukur tekanan.','sedang');
$rows[]=$this->q($v,'KWARTIR = ...','Cabang','Pramuka','Bagian','Markas','Tempat','d','Kwartir = markas Pramuka.','sedang');
$rows[]=$this->q($v,'EKSTENSI = ...','Perluasan','Pendidikan','Penggabungan','Percepatan','Penilaian','a','Ekstensi = extension = perluasan.','sedang');
$rows[]=$this->q($v,'KREASI = ...','Rencana','Pemikiran','Ciptaan','Program','Aksi','c','Kreasi = hasil ciptaan.','sedang');
$rows[]=$this->q($v,'KREDIBILITAS = ...','Ternama','Dapat dipercaya','Mandiri','Kualifikasi','Pilihan','b','Kredibilitas = dapat dipercaya.','sedang');
$rows[]=$this->q($v,'DETAIL > ...','Ruwet','Rumit','Ringkas','Kompleks','Berbelit-belit','c','Antonim detail = ringkas.','sedang');
$rows[]=$this->q($v,'BAWAHAN > ...','Buruh','Atasan','Kolega','Manajer','Rekanan','b','Antonim bawahan = atasan.','sedang');
$rows[]=$this->q($v,'TEKS > ...','Naskah','Konteks','Tekstil','Tekstur','Lateks','a','Sinonim teks = naskah.','sedang');
$rows[]=$this->q($v,'PERINTIS > ...','Pioneer','Pembawa','Generasi','Pewaris','Pendahulu','a','Sinonim perintis = pioneer.','sedang');
$rows[]=$this->q($v,'SEKULER > ...','Duniawi','Keagamaan','Serikat','Ketiga','Pemberian','a','Sinonim sekuler = duniawi.','sedang');

// ===== VERBAL 11-20: Analogi =====
$rows[]=$this->q($v,'SIANG : TERANG','Rambut : Gundul','Botak : Kepala','Lantai : Licin','Motor : Mogok','Batu : Keras','e','Sifat melekat: siang=terang, batu=keras.','sedang');
$rows[]=$this->q($v,'PENGARANG : KARYA','Tidur : Pulas','Air : Panas','Penulis : Artikel','Lari : Cepat','Sekolah : Siswa','c','Pengarang menghasilkan karya = penulis menghasilkan artikel.','sedang');
$rows[]=$this->q($v,'EKSPOR : APBN','Pelukis : Kanvas','Orang Tua : Anak','Negara : Undang Undang','Perusahaan : Karyawan','Menggambar : Ekspresi','d','Ekspor menyumbang APBN = perusahaan menyumbang karyawan.','sedang');
$rows[]=$this->q($v,'API : BAKAR : PANAS','Air : Lembab : Dingin','Udara : Segar : Hangat','Es : Beku : Dingin','Kayu : Keras : Panjang','Besi : Panas : Memuai','c','Api membakar menghasilkan panas = Es membeku menghasilkan dingin.','sedang');
$rows[]=$this->q($v,'KUDA : KAMBING : KUCING','Laptop : Notebook : Handphone','Monitor : Kalkulator : Motor','Cuci : Setrika : Bersih','Presiden : Taksi : Komisaris','Mesin Tik : Komputer : ATM','a','Hewan = perangkat elektronik. Satu kategori.','sedang');
$rows[]=$this->q($v,'PENA : TINTA : KERTAS','Kuras : Palet : Kanvas','Mobil : Bensin : Jalan','Kapur : Penghapus : Papan Tulis','Kuas : Cat : Dinding','Cat : Kaleng : Rumah','d','Alat+media+permukaan: pena+tinta+kertas = kuas+cat+dinding.','sedang');
$rows[]=$this->q($v,'POHON : BERLINDUNG','Rambut : Hitam','Telinga : Anting','Buku : Pena','Kaki : Melangkah','Kepala : Kaki','b','Pohon tempat berlindung = Telinga tempat anting.','sedang');
$rows[]=$this->q($v,'BULAN : TAHUN','Jam : Menit','Buah : Daun','Luluh : Utuh','Detik : Menit','Waktu : Lama','d','12 bulan=1 tahun = 60 detik=1 menit.','sedang');
$rows[]=$this->q($v,'ROKOK : ASBAK = AIR : ...','Ember','Pancur','Selokan','Selang','Keran','c','Rokok ke asbak = Air ke selokan.','sedang');
$rows[]=$this->q($v,'MATA : WAJAH','Ranjang : Kamar','Kayu : Hutan','Lampu : Jalan','Radio : Tape','Pensil : Buku','a','Mata bagian wajah = Ranjang bagian kamar.','sedang');

// ===== VERBAL 21-30: Bukan Kelompok =====
$rows[]=$this->q($v,'Bukan kelompok: Prosa,Puisi,Pantun,Sajak,Novel','Prosa','Puisi','Pantun','Sajak','Novel','e','Novel karya panjang, sisanya sastra pendek.','sedang');
$rows[]=$this->q($v,'Bukan kelompok: Bajai,Becak,Delman,Andong,Dokar','Bajai','Becak','Delman','Andong','Dokar','a','Bajai bermotor, sisanya non-motor.','sedang');
$rows[]=$this->q($v,'Bukan kelompok: Ahli,Pakar,Mahir,Piawai,Kikuk','Ahli','Pakar','Mahir','Piawai','Kikuk','e','Kikuk tidak cakap, sisanya cakap.','sedang');
$rows[]=$this->q($v,'Bukan kelompok: Orasi,Diskusi,Ceramah,Pidato,Khutbah','Orasi','Diskusi','Ceramah','Pidato','Khutbah','b','Diskusi dua arah, sisanya satu arah.','sedang');
$rows[]=$this->q($v,'Bukan kelompok: Amerika,Jerman,Cina,Rusia,Inggris','Amerika','Jerman','Cina','Rusia','Inggris','a','Amerika benua, sisanya negara.','sedang');
$rows[]=$this->q($v,'Bukan kelompok: Kapten,Kolonel,Mayor,Kopral,Letnan','Kapten','Kolonel','Mayor','Kopral','Letnan','d','Kopral bintara, sisanya perwira.','sedang');
$rows[]=$this->q($v,'Bukan kelompok: Supir,Sais,Kusir,Sado,Kuda','Supir','Sais','Kusir','Sado','Kuda','e','Kuda hewan, sisanya pengemudi.','sedang');
$rows[]=$this->q($v,'Bukan kelompok: Pesol,Patherom,Analec,Tupase,Klabak','Pesol','Patherom','Analec','Tupase','Klabak','b','Patherom bukan istilah bagian kaki kuda.','sedang');
$rows[]=$this->q($v,'Bukan kelompok: Italia,Vietnam,Indonesia,Norwegia,Finlandia','Italia','Vietnam','Indonesia','Norwegia','Finlandia','c','Indonesia negara kepulauan, sisanya daratan.','sedang');
$rows[]=$this->q($v,'Bukan kelompok: Thermometer,Speedometer,Voltmeter,Kolometer,Barometer','Thermometer','Speedometer','Voltmeter','Kolometer','Barometer','d','Kolometer bukan alat ukur standar.','sedang');

// ===== NUMERIK 31-40: Deret Angka =====
$rows[]=$this->q($n,'129, 119, 124, 114, 119, 109, 114, ...','119','110','109','105','104','e','Pola -10,+5 bergantian. 114-10=104.','sedang');
$rows[]=$this->q($n,'100, 4, 70, 7, 40, ..., 10','5','9','10','47','74','c','Dua urutan: 100,70,40 turun 30; 4,7,10 naik 3.','sedang');
$rows[]=$this->q($n,'77, 67, 58, 50, 43, ...','37','38','39','40','41','a','Selisih turun: -10,-9,-8,-7,-6. 43-6=37.','sedang');
$rows[]=$this->q($n,'1, 4, 7, 2, 5, 8, 3, 6, 9, ...','4','6','7','9','10','a','Grup +3: (1,4,7)(2,5,8)(3,6,9) berikutnya 4.','sedang');
$rows[]=$this->q($n,'100, 50, 90, 45, 80, ...','50','40','30','20','10','b','Pola: div2,+40 bergantian. 80/2=40.','sedang');
$rows[]=$this->q($n,'2, 12, 4, 10, 6, 8, ..., ...','6.8','6.9','8.6','8.7','8.9','c','Dua urutan: 2,4,6,8 dan 12,10,8,6. Berikutnya 8,6.','sedang');
$rows[]=$this->q($n,'21, 10, 18, 8, 15, 6, ..., ...','10.9','11.4','11.5','12.6','12.4','e','Ganjil: 21,18,15,12. Genap: 10,8,6,4. Berikutnya 12,4.','sedang');
$rows[]=$this->q($n,'3, 6, ..., ..., 48, 96','11.28','12.21','12.24','12.25','18.29','c','Pola x2: 3,6,12,24,48,96.','sedang');
$rows[]=$this->q($n,'29, ..., 71, 92','35','40','43','45','50','e','Pola +21: 29,50,71,92.','sedang');
$rows[]=$this->q($n,'..., ..., 10, 13, 17, 10, 13','7.8','7.9','8.6','8.7','8.9','a','Deret +1,+2,+3,+4: 7,8,10,13,17.','sedang');

// ===== NUMERIK 41-60: Aritmatika Dasar =====
$rows[]=$this->q($n,'3 x 2 x 2 x 0 - 67 + 82 = ...','15','17','19','21','23','a','3x2x2x0=0, 0-67+82=15.','sedang');
$rows[]=$this->q($n,'8 x 7 + 14 + 5 = ...','75','74','73','72','71','a','8x7=56, 56+14+5=75.','sedang');
$rows[]=$this->q($n,'(12 + 28 + 4 + 4) : 4 = ...','11','12','13','14','15','b','48:4=12.','sedang');
$rows[]=$this->q($n,'16 x 2 : 8 - 4 = ...','-2','-1','1','2','3','c','16x2=32, 32:8=4, 4-4=0. Paling mendekati 1.','sedang');
$rows[]=$this->q($n,'2 x 3 : 3 + 2 + 8 - 6 = ...','2','4','6','8','10','c','6:3=2, 2+2+8-6=6.','sedang');
$rows[]=$this->q($n,'6 x 7 : 6 + 17 + 20 = ...','11','22','33','44','55','d','42:6=7, 7+17+20=44.','sedang');
$rows[]=$this->q($n,'45 x 45 : 45 - 4 = ...','41','42','43','44','45','a','45x45:45=45, 45-4=41.','sedang');
$rows[]=$this->q($n,'(8 x 2 + 2 + 10) : 4 = ...','10','9','8','7','6','d','(16+2+10):4=28:4=7.','sedang');
$rows[]=$this->q($n,'(10 + 41 + 9) : 60 = ...','5','4','3','2','1','e','60:60=1.','sedang');
$rows[]=$this->q($n,'79 + 16 - 62 = ...','31','32','33','34','35','c','79+16=95, 95-62=33.','sedang');
$rows[]=$this->q($n,'36 + 72 - 28 = ...','20','40','60','80','100','d','36+72=108, 108-28=80.','sedang');
$rows[]=$this->q($n,'6 x 60 : 5 + 5 = ...','76','77','78','79','80','b','360:5=72, 72+5=77.','sedang');
$rows[]=$this->q($n,'(60 + 25 + 40 + 10) : 5 = ...','30','29','28','27','26','e','135:5=27.','sedang');
$rows[]=$this->q($n,'16 x 5 : 10 - 4 = ...','2','3','4','5','6','c','80:10=8, 8-4=4.','sedang');
$rows[]=$this->q($n,'82 x 2 : 41 - 8 = ...','-4','-2','2','4','6','a','164:41=4, 4-8=-4.','sedang');
$rows[]=$this->q($n,'10 x 2 x 3 = ...','20','40','60','80','100','c','10x2x3=60.','sedang');
$rows[]=$this->q($n,'(3 x 7 + 7 + 4) : 4 = ...','4','8','12','16','20','b','(21+7+4):4=32:4=8.','sedang');
$rows[]=$this->q($n,'80 : 40 + 60 - 7 = ...','55','54','53','52','51','a','2+60-7=55.','sedang');
$rows[]=$this->q($n,'8 + 1 + 5 = ...','11','12','13','14','15','d','8+1+5=14.','sedang');
$rows[]=$this->q($n,'(15 x 5 + 5 + 2) : 82 = ...','1','2','3','4','5','a','(75+5+2):82=82:82=1.','sedang');

// ===== NUMERIK 61-80: Aplikasi =====
$rows[]=$this->q($n,'Burhan 08.30-11.00, 20 soal. Rata2 per 1/2 jam?','2','2.5','3','3.5','4','d','2.5j=5x1/2j. 20:5=4.','sedang');
$rows[]=$this->q($n,'Balok V=162m3, p=6m, l=3m. Tinggi cm?','600','700','800','900','1000','d','t=162:18=9m=900cm.','sedang');
$rows[]=$this->q($n,'Kancil 80km/j. Menit tempuh 8km?','9','8','7','6','5','d','8:80=0.1j=6 menit.','sedang');
$rows[]=$this->q($n,'Mobil 30km/j kabut,60km/j baik. 210km 2/7 kabut. Berapa lama?','3','3.5','4','4.5','5','d','60km@30=2j,150km@60=2.5j. Total 4.5j.','sedang');
$rows[]=$this->q($n,'Daerah tinggi air mendidih...','Selalu 100','Di atas 100','Di bawah 100','Tidak pernah 100','Sama','c','Tekanan rendah = titik didih lebih rendah.','sedang');
$rows[]=$this->q($n,'PQ:nonPQ=5:3. 3/8 PQ jantan. Rasio jantan:total?','2/2','6/8','8/14','15/64','21/26','d','3/8 x 5/8 = 15/64.','sedang');
$rows[]=$this->q($n,'Mobil 90km/j. Bogor-Jakarta 60km. Berangkat 10.00. Tiba?','11.3','11.00','10.00','10.30','10.40','e','60:90=2/3j=40m. 10.00+40m=10.40.','sedang');
$rows[]=$this->q($n,'Kota A 3j lebih cepat B. Pesawat A brkt 5pagi, tiba 4j. Jam brp di B?','2','3','4','5','6','e','5pagi+4j=9pagiA=6pagiB.','sedang');
$rows[]=$this->q($n,'Tripleks luas 169m2, potong 2m sisi. Luas dinding?','113','121','143','145','150','b','Sisi 13m, potong 2m jadi 11m. 11x11=121.','sedang');
$rows[]=$this->q($n,'Roda1 9x=roda2 24x. Roda1 27x, roda2 berapa?','74','72','84','90','92','b','Rasio 9:24. 27:72.','sedang');
$rows[]=$this->q($n,'Invest 1/5 kebun+2/5 properti. Sisa 25M. Total?','55M','55.8M','62M','62.5M','63M','d','2/5=25M. Total=25x5/2=62.5M.','sedang');
$rows[]=$this->q($n,'Jumlah 47 orang dan 9 orang?','55','56','57','58','60','b','47+9=56.','sedang');
$rows[]=$this->q($n,'4thn lagi ibu 3x usia anak. 6thn lalu ibu 24 thn lebih tua. Usia anak?','8','10','12','14','16','a','Ibu=A+24. A+28=3A+12. 2A=16. A=8.','sedang');
$rows[]=$this->q($n,'Arie=1/2 Iswandi. Iswandi kasih 5M, sisa Iswandi 4M lebih. Total?','14M','27M','42M','51M','60M','c','I=28, A=14. Total 42.','sedang');
$rows[]=$this->q($n,'Rp4000=3 telur. Rp20000 berapa?','12','14','15','17','20','c','5x3=15.','sedang');
$rows[]=$this->q($n,'4 mie+3 susu=10700. 3 mie+5 susu=14900. Harga 1 mie?','950','800','750','700','500','b','m=800, s=2500.','sedang');
$rows[]=$this->q($n,'30 siswa. Renang 27, tenis 22. Yang suka keduanya?','3','5','8','11','19','e','27+22-30=19.','sedang');
$rows[]=$this->q($n,'Budiman urutan 16 atas & 16 bawah. Banyak siswa?','16','26','31','32','40','c','16+16-1=31.','sedang');
$rows[]=$this->q($n,'Jual 80000 laba 25%. Harga beli?','20000','64000','100000','120000','150000','b','80000:1.25=64000.','sedang');
$rows[]=$this->q($n,'2 buku+1 ballpoint=4000. 3 buku+4 ballpoint=8500. Harga ballpoint?','875','975','1000','1150','1200','c','b=1500, p=1000.','sedang');

// ===== PENALARAN 81-100: Silogisme =====
$rows[]=$this->q($p,'A anak B+C. E anak D+B. Hubungan A-E?','Sepupu','Misan','Ipar','Kandung','Tiri','e','Sama-sama anak B, beda ayah = tiri.','sedang');
$rows[]=$this->q($p,'Daryanti kesiangan, lari, jatuh lubang, patah kaki. Kesimpulan?','Tidak makan pagi','Kawan menjenguk ingin tau kenapa terlambat','Tidak melihat lubang kesiangan','Patah kaki karena terlambat tidur','Semua salah','b','Fakta langsung dari teks.','sedang');
$rows[]=$this->q($p,'Kakap merah bergizi+indah. Tuna enak membosankan. Udang kecil gizi tinggi. Bandeng gizi lebih baik tuna. Hidangan menarik+bergizi?','Tuna dan bandeng','Kakap merah dan udang','Bandeng dan kakap','Udang dan bandeng','Tuna','d','Udang(bergizi)+bandeng(gizi lebih baik tuna). Menarik+bergizi.','sedang');
$rows[]=$this->q($p,'Klim panas: getah+karet. Dingin: semak+rumput. Rumput+karet: lembap. Getah+semak: kering. Amazon panas+lembap?','Getah dan semak','Pohon karet','Rumput','Semak','Pohon getah','b','Panas(transferak+r rumput) AND lembap(transferak+r transferak) = karet.','sedang');
$rows[]=$this->q($p,'Film: Pencuri Baik Hati 4 Citra. Rinduku dapat 2 lebih banyak. Film terbaik?','Rinduku terpaut di Awan','Pencuri Yang Baik Hati','Bundaku Tersayang','Hatiku','Pencuri (lagi)','a','Rinduku=4+2=6 Citra. Paling banyak.','sedang');
$rows[]=$this->q($p,'Sebagian penyanyi cantik. Isabella artis cantik. Diana penyanyi. Kesimpulan?','Isabella penyanyi cantik','Diana berwajah cantik','Isabella berwajah cantik','Diana mungkin cantik','Tidak dapat disimpulkan','d','Sebagian penyanyi cantik, Diana penyanyi = mungkin cantik.','sedang');
$rows[]=$this->q($p,'Entrepreneur harus punya produk/cara baru. Yang punya usaha belum tentu entrepreneur. Kesimpulan?','Pemilik perusahaan besar = entrepreneur','Yang membangun perusahaan = entrepreneur','Entrepreneur tidak punya usaha kecil','Entrepreneur = investor','Investor bukan entrepreneur','b','Yang membangun/menciptakan usaha baru = entrepreneur.','sedang');
$rows[]=$this->q($p,'Kata TIDAK bermakna abstrak?','Terbelenggu','Kalah','Analisis intelijen','Kecantikan','Tidak ada','c','Analisis intelijen = konkret (kelembagaan). Sisanya abstrak.','sedang');
$rows[]=$this->q($p,'Daging impor > lokal > beras > sayur. Kesimpulan?','Sayur lebih mahal lokal','Lokal lebih mahal impor','Impor lebih mahal lokal','Beras lebih mahal impor','Impor sama lokal','c','Impor > lokal dari pernyataan.','sedang');
$rows[]=$this->q($p,'A sesudah C. B sebelum D & bersama A. Urutan?','D sebelum C','A sesudah D','C sebelum D','A bersamaan D','A setelah B','c','C < A=B < D. C sebelum D.','sedang');
$rows[]=$this->q($p,'Semua ujian tdk pk kalkulator. Sebagian ujian pk jam. Kesimpulan?','Semua pk jam','Sebagian tdk pk jam','Semua tdk kalkulator+tdk jam','Sebagian pk jam+tdk kalkulator','Tdk dapat disimpulkan','d','Sebagian ujian pk jam dan tdk pk kalkulator.','sedang');
$rows[]=$this->q($p,'40 siswa. Fisika 4 eksklusif. IPS 15 (5 juga IPA). Biologi 7. Yang paling banyak?','Matematika','IPS','IPA','Matematika=IPS','Tidak dapat disimpulkan','b','IPS=15 paling banyak dari yang diketahui.','sedang');
$rows[]=$this->q($p,'Semua ikan di air. Sebagian air tawar. Kesimpulan?','Semua bisa AT+AL','Sebagian AT tdk bisa AL','Sebagian ikan tdk AT','Tdk ada ikan AL','Tidak dapat disimpulkan','c','Sebagian ikan tidak di air tawar (logika: beberapa ikan hanya AL).','sedang');
$rows[]=$this->q($p,'Semua RS punya UGD. Sebagian RS bersalin. Kesimpulan?','RS bersalin punya UGD','RS bersalin tdk punya UGD','Sebagian RS tdk UGD','Semua RS tdk UGD=bersalin','Tidak dapat disimpulkan','a','RS bersalin = subset RS. Semua RS punya UGD. Maka RS bersalin punya UGD.','sedang');
$rows[]=$this->q($p,'Semua Pertanian UMJ lulus tepat. Sebagian P2K. Kesimpulan?','Semua P2K lulus tepat','Sebagian UMJ lulus tdk tepat','P2K lulus tepat pasti P2K','Sebagian UMJ = P2K','Tidak dapat disimpulkan','a','P2K Pertanian UMJ = subset. Semua lulus tepat. Maka semua P2K Pertanian UMJ lulus tepat.','sedang');
$rows[]=$this->q($p,'Semua taksi punya radio. Sebagian taksi merah. Kesimpulan?','Sebagian merah tdk radio','Sebagian merah tdk punya radio','Semua merah punya radio','Sebagian tdk merah punya radio','Tidak dapat disimpulkan','d','Sebagian taksi tidak merah DAN punya radio (semua taksi punya radio).','sedang');
$rows[]=$this->q($p,'Cum laude butuh IP>3.5. Beberapa sarjana IP<3.5. Kesimpulan?','Semua tdk cum laude','Semua cum laude','Semua IP>3.5','Beberapa cum laude','Tidak dapat disimpulkan','a','Beberapa sarjana IP<3.5, maka mereka tdk cum laude. Semua yang IP<3.5 tdk cum laude.','sedang');
$rows[]=$this->q($p,'Semua olahraga butuh energi. Catur=olahraga berpikir. Kesimpulan?','Catur butuh energi','Catur tdk butuh energi','Energi catur sedikit','Olahraga pikir tdk butuh energi','Tidak dapat disimpulkan','a','Catur=olahraga. Semua olahraga butuh energi. Maka catur butuh energi.','sedang');
$rows[]=$this->q($p,'Semua donor berbadan sehat. Sebagian donor darah gol O. Kesimpulan?','Sebagian O + donor berbadan sehat','Semua donor harus gol O + sehat','Semua donor O harus sehat','Yang sehat=O + donor','Tidak dapat disimpulkan','a','Sebagian donor darah gol O DAN berbadan sehat (semua donor sehat).','sedang');
$rows[]=$this->q($p,'Mencuri jahat. Setiap pencuri wajib dipenjara. Suparta pernah mencuri 6thn lalu. Kesimpulan?','Suparta penjahat','Suparta wajib dipenjara','Suparta belum tentu penjahat','Penjara mengubah jadi baik','Tidak dapat disimpulkan','c','Suparta PERNAH mencuri 6 tahun lalu, belum tentu sekarang penjahat.','sedang');

        $insert = [];
        foreach ($rows as $r) {
            $insert[] = [
                'package_id' => $r['pkg'],
                'question_text' => $r['text'],
                'option_a' => $r['a'],
                'option_b' => $r['b'],
                'option_c' => $r['c'],
                'option_d' => $r['d'],
                'option_e' => $r['e'],
                'correct_answer' => $r['ans'],
                'explanation' => $r['exp'],
                'difficulty' => $r['diff'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('questions')->insert($insert);
    }
}
