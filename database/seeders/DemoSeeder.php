<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\JabatanPenduduk;
use App\Models\Kunjungan;
use App\Models\Pemohon;
use App\Models\Penduduk;
use App\Models\SettingsKegiatan;
use App\Models\SettingsKunjungan;
use Illuminate\Database\Seeder;

/**
 * Data contoh (SEMUA PALSU) untuk demo.
 * Aman dijalankan berulang: memakai firstOrCreate, tidak menimpa data atau password yang sudah ada.
 *
 *   php artisan db:seed --class=DemoSeeder
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Jabatan
        $jabatan = [];
        foreach (['Kepala Dinas', 'Sekretaris Daerah', 'Kepala Bagian Umum', 'Kepala Bidang Pelayanan'] as $nama) {
            $jabatan[$nama] = Jabatan::firstOrCreate(['nama_jabatan' => $nama]);
        }

        // 2) Pegawai (akun penduduk) + jabatan yang dipegang
        $pegawai = [
            ['budi', 'Budi Santoso', '3513000000000011', '3513000000000012', 'L', 'Sekretaris Daerah', 'budi123'],
            ['siti', 'Siti Rahmawati', '3513000000000021', '3513000000000022', 'P', 'Kepala Bagian Umum', 'siti123'],
            ['andi', 'Andi Wijaya', '3513000000000031', '3513000000000032', 'L', 'Kepala Bidang Pelayanan', 'andi123'],
        ];

        $jp = [];
        foreach ($pegawai as [$username, $nama, $nik, $kk, $jk, $namaJabatan, $password]) {
            $orang = Penduduk::firstOrCreate(
                ['username' => $username],
                [
                    'nama_penduduk' => $nama,
                    'nik' => $nik,
                    'kk' => $kk,
                    'jenis_kelamin' => $jk,
                    'alamat' => 'Jl. Contoh No. 1 (data palsu)',
                    'password' => $password,
                    'status' => 'Penduduk',
                ]
            );

            $jp[$username] = JabatanPenduduk::firstOrCreate(
                ['id_jabatan' => $jabatan[$namaJabatan]->id_jabatan, 'id_penduduk' => $orang->id_penduduk],
                ['status' => 'Y']
            );
        }

        // 3) Jadwal kunjungan (relatif terhadap hari ini, jadi selalu "mendatang")
        $jadwal = [];
        foreach ($jp as $username => $pemegang) {
            foreach ([2 => ['08:00:00', '12:00:00'], 3 => ['13:00:00', '16:00:00']] as $tambahHari => [$mulai, $selesai]) {
                $jadwal[$username][$tambahHari] = SettingsKunjungan::firstOrCreate(
                    [
                        'id_jabatan_penduduk' => $pemegang->id_jabatan_penduduk,
                        'tanggal' => now()->addDays($tambahHari)->toDateString(),
                        'jam_aktif' => $mulai,
                    ],
                    ['jam_non_aktif' => $selesai, 'status' => 'Y']
                );
            }
        }

        // 4) Kegiatan pejabat
        foreach ($jp as $username => $pemegang) {
            SettingsKegiatan::firstOrCreate(
                ['id_jabatan_penduduk' => $pemegang->id_jabatan_penduduk, 'kegiatan' => 'Rapat koordinasi (contoh)'],
                [
                    'tanggal_awal' => now()->addDays(6)->toDateString(),
                    'tanggal_akhir' => now()->addDays(7)->toDateString(),
                ]
            );
        }

        // 5) Pemohon demo
        $pemohon = Pemohon::firstOrCreate(
            ['email' => 'pemohon.demo@contoh.test'],
            ['nama' => 'Pemohon Demo', 'telepon' => '081200000001', 'password' => 'demo12345']
        );

        // 6) Tiga pengajuan dengan status berbeda
        $this->pengajuan($pemohon, $jadwal['budi'][2], 'Konsultasi program kerja (contoh)', [], '09:00:00');

        $this->pengajuan($pemohon, $jadwal['siti'][2], 'Penyerahan dokumen (contoh)', [
            'konfrimasi_admin' => 'Y', 'tanggal_waktu_admin' => now(), 'catatan_admin' => 'Silakan datang tepat waktu.',
            'konfrimasi_penduduk' => 'Y', 'tanggal_waktu_penduduk' => now(), 'catatan_penduduk' => 'Disetujui.',
        ], '09:30:00');

        $this->pengajuan($pemohon, $jadwal['andi'][3], 'Audiensi (contoh)', [
            'konfrimasi_admin' => 'Y', 'tanggal_waktu_admin' => now(),
            'konfrimasi_penduduk' => 'T', 'tanggal_waktu_penduduk' => now(), 'catatan_penduduk' => 'Jadwal bentrok dengan rapat.',
        ], '14:00:00');

        $this->command->info('Data demo siap. Akun pejabat: budi/budi123, siti/siti123, andi/andi123. Pemohon: pemohon.demo@contoh.test / demo12345');
    }

    private function pengajuan(Pemohon $pemohon, SettingsKunjungan $jadwal, string $tujuan, array $keputusan, string $jam): void
    {
        Kunjungan::firstOrCreate(
            [
                'id_pemohon' => $pemohon->id_pemohon,
                'id_settings_kunjungan' => $jadwal->id_settings_kunjungan,
                'tujuannya' => $tujuan,
            ],
            array_merge(['tanggal_waktu' => $jadwal->tanggal->format('Y-m-d').' '.$jam], $keputusan)
        );
    }
}
