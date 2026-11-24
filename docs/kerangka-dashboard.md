# Kerangka Dashboard Monitoring Tracer Study

Fokus: sisi admin. Tidak mencakup pembuatan kuesioner dan pengiriman email.

## 1. Kartu indikator (halaman Ringkasan)

| Kartu | Rumus | Format |
| --- | --- | --- |
| Total responden | `COUNT(*)` dari `jawaban_tracer` | angka |
| Tingkat keterserapan | `COUNT(status_kerja='BEKERJA') / COUNT(*) * 100` | `78,4%` |
| Rata-rata relevansi | `AVG(relevansi)` untuk yang bekerja | `4,2 / 5` |
| Persentase relevan | `COUNT(relevansi >= 4) / COUNT(relevansi) * 100` | `81,3%` |

Semua kartu mengikuti filter global: tahun lulus, prodi, status kerja, dan rentang tanggal submit.

## 2. Menu dashboard

1. **Ringkasan** — empat kartu indikator, grafik tren keterserapan per tahun lulus, dan grafik komposisi status kerja.
2. **Keterserapan** — bar chart keterserapan per program studi, tabel detail jumlah responden dan jumlah yang bekerja.
3. **Relevansi** — distribusi skor 1–5, rata-rata per prodi, dan daftar bidang pekerjaan dengan skor relevansi tertinggi/terendah.
4. **Profil Alumni** — sebaran bidang pekerjaan, skala gaji, dan kabupaten dominan.
5. **Data Jawaban** — tabel mentah dengan pencarian dan filter, sebagai bahan pengecekan terhadap data dummy.

## 3. Contoh query PostgreSQL

### Keterserapan per tahun lulus

```sql
SELECT
  a.tahun_lulus,
  COUNT(*) AS total_responden,
  COUNT(*) FILTER (WHERE j.status_kerja = 'BEKERJA') AS total_bekerja,
  ROUND(
    100.0 * COUNT(*) FILTER (WHERE j.status_kerja = 'BEKERJA') / COUNT(*),
    1
  ) AS persentase_keterserapan
FROM jawaban_tracer j
JOIN alumni a ON a.nrp = j.nrp
GROUP BY a.tahun_lulus
ORDER BY a.tahun_lulus;
```

### Keterserapan per program studi

```sql
SELECT
  a.prodi,
  COUNT(*) AS total_responden,
  ROUND(
    100.0 * COUNT(*) FILTER (WHERE j.status_kerja = 'BEKERJA') / COUNT(*),
    1
  ) AS persentase_keterserapan
FROM jawaban_tracer j
JOIN alumni a ON a.nrp = j.nrp
GROUP BY a.prodi
ORDER BY persentase_keterserapan DESC;
```

### Relevansi pekerjaan

```sql
SELECT
  a.prodi,
  COUNT(j.relevansi) AS total_dinilai,
  ROUND(AVG(j.relevansi), 2) AS rata_rata_relevansi,
  ROUND(
    100.0 * COUNT(*) FILTER (WHERE j.relevansi >= 4)
    / NULLIF(COUNT(j.relevansi), 0),
    1
  ) AS persentase_relevan
FROM jawaban_tracer j
JOIN alumni a ON a.nrp = j.nrp
WHERE j.status_kerja = 'BEKERJA'
GROUP BY a.prodi
ORDER BY rata_rata_relevansi DESC;
```

### Distribusi bidang pekerjaan

```sql
SELECT
  bidang_pekerjaan,
  COUNT(*) AS jumlah
FROM jawaban_tracer
WHERE status_kerja = 'BEKERJA'
GROUP BY bidang_pekerjaan
ORDER BY jumlah DESC;
```

## 4. Wireframe sederhana

```text
+------------------------------------------------------------------+
|  TRACER STUDY PENS - MONITORING ADMIN              [Filter ▾]    |
+------------------------------+-----------------------------------+
| Total responden   1.240      | Tingkat keterserapan    78,4%     |
+------------------------------+-----------------------------------+
| Rata-rata relevansi 4,2/5    | Persentase relevan      81,3%     |
+------------------------------+-----------------------------------+
| Tren keterserapan per tahun  | Komposisi status kerja            |
| [line chart]                 | [donut chart]                     |
+------------------------------+-----------------------------------+
| Keterserapan per prodi       | Distribusi skor relevansi         |
| [bar chart]                  | [bar chart 1-5]                   |
+------------------------------------------------------------------+
```

## 5. Urutan pengerjaan

1. Buat tabel sesuai `kontrak-data-tracer.md`.
2. Isi 100 baris dummy dengan komposisi status kerja yang bervariasi.
3. Jalankan query di atas dan cocokkan angkanya dengan perhitungan manual.
4. Baru pasang grafik ke dashboard.

Dengan urutan ini, kesalahan perhitungan ketemu sebelum grafik dibuat.
