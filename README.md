# SI Kunjung Pemda

Aplikasi layanan kunjungan instansi pemerintahan. Pemohon mengajukan kunjungan secara daring kepada pejabat tujuan.
Admin dan pejabat memproses pengajuan tersebut. Dibangun dengan **Laravel 13**, **MariaDB/MySQL**, dan **Bootstrap 5**.

## Peran pengguna

| Peran | Login | Kemampuan |
|---|---|---|
| Publik (tanpa login) | - | Melihat jadwal kunjungan yang dibuka (dengan pencarian dan filter) dan struktur jabatan |
| Pemohon | email + password | Daftar, mengajukan kunjungan, melihat riwayat, mengubah atau menghapus pengajuan selama belum diproses |
| Pejabat (Penduduk) | username + password | Menyetujui atau menolak pengajuan yang ditujukan kepadanya (dengan catatan), melihat jadwal sendiri, mengelola kegiatan sendiri |
| Admin | username + password | Mengelola jabatan, penduduk, jabatan pegawai, jadwal kunjungan, kegiatan, dan memproses semua pengajuan |

## Alur pengajuan

1. Admin membuat **jadwal kunjungan** untuk seorang pejabat (tanggal, jam mulai, jam selesai).
2. Pemohon memilih jadwal tersebut dan mengisi tujuan kunjungan.
3. **Admin** dan **pejabat tujuan** masing-masing memutuskan Setujui atau Tolak. Menolak wajib disertai catatan.
4. Status pengajuan:
   - **Ditolak** bila salah satu pihak menolak.
   - **Disetujui** bila admin dan pejabat sama-sama menyetujui.
   - **Menunggu** untuk keadaan lainnya.
5. Pemohon hanya dapat mengubah atau menghapus pengajuan yang belum diputuskan siapa pun.

## Keamanan yang diterapkan

- Password disimpan terenkripsi (bcrypt), tidak pernah berupa teks biasa.
- Dua *guard* login terpisah: `penduduk` (admin dan pejabat) dan `pemohon`.
- Middleware `role` membatasi akses halaman sesuai peran.
- Pejabat hanya dapat membuka pengajuan yang ditujukan kepadanya, dan pemohon hanya miliknya sendiri (selain itu 404).
- Halaman publik tidak menampilkan data pribadi (NIK, KK, alamat, username).
- Validasi pada semua formulir, termasuk pengecekan jadwal bentrok.

## Cara menjalankan

1. Salin `.env.example` menjadi `.env`, lalu isi koneksi database (`DB_DATABASE=visitor`, dan seterusnya).
2. Buat database `visitor`, lalu impor `database/sql/visitor_terbaru.sql`.
3. Pasang dependensi dan kunci aplikasi:
   ```
   composer install
   php artisan key:generate
   ```
4. (Opsional) Isi data contoh:
   ```
   php artisan db:seed --class=DemoSeeder
   ```
5. Jalankan:
   ```
   php artisan serve
   ```
   Buka `http://127.0.0.1:8000`.

> Database dibuat dari berkas SQL, jadi `php artisan migrate` **tidak** dipakai.

## Akun contoh (data palsu, dari DemoSeeder)

| Peran | Login | Password |
|---|---|---|
| Pejabat | `budi` | `budi123` |
| Pejabat | `siti` | `siti123` |
| Pejabat | `andi` | `andi123` |
| Pemohon | `pemohon.demo@contoh.test` | `demo12345` |

Akun admin dibuat sendiri dan tidak dicantumkan di sini.

## Struktur kode yang penting

```
app/Models/                         Model + scope query (Kunjungan, SettingsKunjungan, JabatanPenduduk, ...)
app/Http/Controllers/Admin/         Halaman admin
app/Http/Controllers/Penduduk/      Halaman pejabat
app/Http/Controllers/Pemohon/       Halaman pemohon
app/Http/Controllers/PublikController.php   Halaman publik
app/Http/Middleware/EnsureUserHasRole.php   Pembatas akses per peran
database/sql/visitor_terbaru.sql    Struktur dan data database
database/seeders/DemoSeeder.php     Data contoh
routes/web.php                      Seluruh route
```
