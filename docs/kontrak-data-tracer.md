# Kontrak Data Tracer Study — v1

Status: draft untuk disepakati bersama
Tanggal: 24 November 2026

| Pihak | NRP / Kelas | Bagian |
| --- | --- | --- |
| Mey Risa Handayani | 3124521011 / 3 IT A LA | Kuesioner dinamis, distribusi email, pengumpulan jawaban |
| Elsa Lady Dia Fatma | 3124521025 / 3 IT A | Analisis, visualisasi, monitoring keterserapan dan relevansi, database |

## Tujuan

Menyamakan struktur data sejak awal supaya pengerjaan bisa paralel. Elsa memakai data dummy dengan struktur yang sama persis dengan data asli dari Mey. Saat data asli tersedia, yang diganti hanya isinya, bukan struktur tabel, query, atau dashboard.

## Alur data

`Kuesioner (Mey)` → `tabel jawaban_tracer` → `query agregasi (Elsa)` → `dashboard`

1. Elsa membuat 100 baris dummy mengikuti tabel di bawah ini.
2. Mey mengirim data asli dengan nama kolom dan format yang sama.
3. Elsa mengganti isi tabel dengan data asli, lalu dashboard langsung terbaca.

## Definisi tabel

### `alumni`

| Kolom | Tipe | Wajib | Keterangan |
| --- | --- | --- | --- |
| `nrp` | varchar(12) | Ya | Primary key, 10 digit angka |
| `nama` | varchar(100) | Ya | Nama lengkap |
| `prodi` | varchar(100) | Ya | Contoh: `Teknik Informatika` |
| `tahun_lulus` | smallint | Ya | Contoh: `2024` |
| `email` | varchar(150) | Ya | Dipakai untuk distribusi kuesioner |

### `jawaban_tracer`

| Kolom | Tipe | Wajib | Keterangan |
| --- | --- | --- | --- |
| `id_jawaban` | bigserial | Ya | Primary key, dibuat otomatis |
| `nrp` | varchar(12) | Ya | Foreign key ke `alumni.nrp` |
| `status_kerja` | enum | Ya | `BEKERJA`, `KULIAH_LANJUT`, `WIRAUSAHA`, `BELUM_BEKERJA` |
| `nama_perusahaan` | varchar(150) | Jika BEKERJA | Diisi `NULL` untuk status lain |
| `bidang_pekerjaan` | varchar(100) | Jika BEKERJA | Pakai nama konsisten, contoh `Teknologi Informasi` |
| `jabatan` | varchar(100) | Jika BEKERJA | Contoh `Frontend Developer` |
| `tanggal_mulai` | date | Jika BEKERJA | Format `YYYY-MM-DD` |
| `skala_gaji` | varchar(20) | Jika BEKERJA | `<3000000`, `3000000-5000000`, `5000000-10000000`, `>10000000` |
| `relevansi` | smallint | Jika BEKERJA | 1 = tidak relevan, 5 = sangat relevan |
| `lokasi_kabupaten` | varchar(100) | Jika BEKERJA | Contoh `Surabaya` |
| `submitted_at` | timestamptz | Ya | Waktu pengisian, zona `Asia/Jakarta` |

## Skema PostgreSQL

```sql
CREATE TABLE alumni (
  nrp varchar(12) PRIMARY KEY,
  nama varchar(100) NOT NULL,
  prodi varchar(100) NOT NULL,
  tahun_lulus smallint NOT NULL,
  email varchar(150) NOT NULL
);

CREATE TYPE status_kerja_t AS ENUM
  ('BEKERJA', 'KULIAH_LANJUT', 'WIRAUSAHA', 'BELUM_BEKERJA');

CREATE TABLE jawaban_tracer (
  id_jawaban bigserial PRIMARY KEY,
  nrp varchar(12) NOT NULL REFERENCES alumni(nrp),
  status_kerja status_kerja_t NOT NULL,
  nama_perusahaan varchar(150),
  bidang_pekerjaan varchar(100),
  jabatan varchar(100),
  tanggal_mulai date,
  skala_gaji varchar(20),
  relevansi smallint CHECK (relevansi BETWEEN 1 AND 5),
  lokasi_kabupaten varchar(100),
  submitted_at timestamptz NOT NULL DEFAULT now(),
  CHECK (
    status_kerja <> 'BEKERJA'
    OR (
      nama_perusahaan IS NOT NULL
      AND bidang_pekerjaan IS NOT NULL
      AND jabatan IS NOT NULL
      AND tanggal_mulai IS NOT NULL
      AND relevansi IS NOT NULL
    )
  )
);
```

## Aturan nilai

- Data kosong ditulis `NULL`, bukan string kosong `""` dan bukan `-`.
- Status kerja ditulis persis sesuai enum, bukan `bekerja`, `Kerja`, atau `Working`.
- `skala_gaji` memakai rentang angka, bukan label `3-5 juta`.
- Satu `nrp` hanya punya satu baris di `jawaban_tracer`. Jika alumni mengisi ulang, baris lama diperbarui.
- `bidang_pekerjaan` memakai satu ejaan yang sama untuk kategori yang sama.
- `relevansi` hanya diisi untuk `status_kerja = BEKERJA`.

## Format pertukaran

Mey bisa memilih satu dari dua cara:

1. File CSV dengan header persis sesuai nama kolom di atas.
2. Endpoint `GET /api/tracer/jawaban` yang mengembalikan array objek dengan kunci yang sama.

Contoh satu baris:

```json
{
  "nrp": "3124521025",
  "status_kerja": "BEKERJA",
  "nama_perusahaan": "PT Telkom Indonesia",
  "bidang_pekerjaan": "Teknologi Informasi",
  "jabatan": "Frontend Developer",
  "tanggal_mulai": "2025-08-01",
  "skala_gaji": "3000000-5000000",
  "relevansi": 5,
  "lokasi_kabupaten": "Surabaya",
  "submitted_at": "2026-11-24T09:15:00+07:00"
}
```

## Metrik yang dihitung Elsa

- **Tingkat keterserapan** = `COUNT(status_kerja = 'BEKERJA') / COUNT(jawaban) * 100`, dikelompokkan per tahun lulus dan prodi.
- **Rata-rata relevansi** = `AVG(relevansi)` dari alumni dengan status `BEKERJA`.
- **Persentase relevan** = `COUNT(relevansi >= 4) / COUNT(relevansi) * 100`.
- **Distribusi bidang pekerjaan**, **skala gaji**, dan **lokasi kabupaten**.

## Aturan perubahan

- Kontrak ini diberi versi `v1`.
- Jika ada kolom baru atau format berubah, pihak yang mengusulkan mengabari pihak lain sebelum kode dibuat.
- Perubahan dicatat sebagai `v2`, bukan mengubah diam-diam `v1`.

## Balasan singkat ke Mey

Assalamu'alaikum Mey 🙏

Aku bikin kontrak data dulu biar kerjaan kita aman walau dikerjakan paralel. Isinya cuma kesepakatan nama kolom, format nilai, dan cara kirim data. Tolong dicek ya, kalau ada kolom yang tidak bisa diambil dari kuesionermu, kita ubah sekarang sebelum aku bikin data dummy. Nanti aku buat 100 dummy pakai format ini, dan kamu tinggal kirim data aslinya dengan struktur yang sama.

Makasih Mey 🙏
