# Bab 1 — Pengembangan Sistem Analisis dan Visualisasi Data Tracer Study Alumni PENS untuk Monitoring Keterserapan dan Relevansi Pekerjaan Berbasis Web

## 1.1 Latar Belakang

Tracer study merupakan salah satu mekanisme untuk memantau kabar alumni setelah menyelesaikan pendidikan, termasuk status kerja, bidang pekerjaan, dan kesesuaian pekerjaan dengan bidang studi. Data yang terkumpul dari tracer study memiliki nilai strategis bagi perguruan tinggi, antara lain untuk mengetahui tingkat keterserapan alumni di dunia kerja serta mengevaluasi relevansi kurikulum terhadap kebutuhan industri.

Pengumpulan data tracer study di lingkungan PENS dilakukan melalui kuesioner yang dibagikan kepada alumni. Di sisi lain, hasil kuesioner tersebut masih memerlukan pengolahan lanjutan agar dapat dibaca sebagai informasi. Proses rekapitulasi yang dilakukan secara terpisah dari pengumpulan data menyebabkan penyajian indikator keterserapan dan relevansi pekerjaan memerlukan waktu tambahan dan berpotensi menimbulkan perbedaan cara hitung antarperiode.

Proyek Akhir ini berfokus pada sisi analisis dan visualisasi data tracer study. Pembagian dengan rekan pengembangan yang mengerjakan manajemen kuesioner dinamis dan otomasi distribusi dilakukan secara paralel dengan tetap menggunakan satu aplikasi dan struktur data yang sama. Dengan adanya sistem yang menyajikan indikator keterserapan dan relevansi dalam bentuk dashboard, pengguna admin dapat memantau hasil tracer study secara lebih cepat, konsisten, dan mudah dipahami.

## 1.2 Rumusan Masalah

Berdasarkan latar belakang tersebut, rumusan masalah dalam pengembangan ini adalah sebagai berikut.

1. Bagaimana merancang struktur data tracer study yang konsisten untuk menyimpan status kerja, bidang pekerjaan, dan tingkat relevansi alumni PENS?
2. Bagaimana mengimplementasikan perhitungan tingkat keterserapan alumni berdasarkan tahun lulus dan program studi?
3. Bagaimana mengukur tingkat relevansi pekerjaan alumni terhadap bidang studinya?
4. Bagaimana menyajikan hasil analisis tersebut dalam bentuk dashboard monitoring berbasis web yang mudah digunakan oleh admin?

## 1.3 Tujuan Pengembangan

Tujuan dari pengembangan ini adalah:

1. Merancang struktur data tracer study yang menjadi acuan bersama antara bagian pengumpulan kuesioner dan bagian analisis.
2. Mengimplementasikan perhitungan tingkat keterserapan alumni per tahun lulus dan program studi.
3. Mengukur tingkat relevansi pekerjaan alumni menggunakan skala penilaian yang ditetapkan bersama.
4. Membangun dashboard monitoring keterserapan dan relevansi pekerjaan alumni PENS berbasis web.

## 1.4 Manfaat Pengembangan

### 1.4.1 Manfaat bagi PENS

Hasil pengembangan ini diharapkan dapat membantu PENS memantau keterserapan dan relevansi pekerjaan alumni sebagai bahan evaluasi program studi dan kurikulum.

### 1.4.2 Manfaat bagi Admin

Admin dapat melihat indikator tracer study dalam satu tampilan dashboard tanpa harus melakukan rekapitulasi manual dari data kuesioner.

### 1.4.3 Manfaat bagi Pengembangan Berikutnya

Struktur data dan definisi indikator yang dibuat pada pengembangan ini dapat digunakan kembali oleh bagian manajemen kuesioner dan otomasi distribusi, sehingga kedua bagian tetap selaras meskipun dikerjakan secara paralel.

## 1.5 Batasan Masalah

1. Pengembangan ini berfokus pada analisis, visualisasi, dan monitoring data tracer study alumni PENS.
2. Perancangan kuesioner dinamis dan pengiriman email otomatis menjadi bagian dari rekan pengembangan lain, bukan fokus utama dalam proposal ini.
3. Data yang dianalisis adalah data alumni yang telah terkumpul melalui kuesioner; selama masa pengerjaan paralel digunakan data dummy dengan struktur yang sama dengan data asli.
4. Pengguna utama fitur pada bagian ini adalah admin.

## 1.6 Ruang Lingkup

Ruang lingkup pengembangan ini meliputi:

1. Perancangan struktur data bersama untuk status kerja, bidang pekerjaan, dan relevansi alumni.
2. Pengolahan data menjadi indikator keterserapan dan relevansi pekerjaan.
3. Visualisasi indikator dalam bentuk grafik dan tabel ringkasan pada dashboard web.
4. Pengelolaan basis data PostgreSQL sebagai penyimpanan data tracer study.

## 1.7 Definisi Operasional

| Istilah | Definisi |
| --- | --- |
| Keterserapan | Perbandingan jumlah alumni dengan status kerja terhadap jumlah alumni yang mengisi kuesioner, dinyatakan dalam persentase. |
| Relevansi pekerjaan | Tingkat kesesuaian antara pekerjaan alumni dengan bidang studi yang ditempuh, diukur dengan skala 1 sampai 5. |
| Dashboard | Tampilan web yang menyajikan ringkasan indikator tracer study dalam bentuk grafik dan angka. |
| Data dummy | Data contoh dengan struktur sama seperti data asli yang digunakan sebelum data kuesioner tersedia. |
