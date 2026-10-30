<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';
    protected $primaryKey = 'id_kunjungan';
    public $timestamps = false;

    protected $fillable = [
        'id_settings_kunjungan', 'id_pemohon',
        'konfrimasi_admin', 'tanggal_waktu_admin',
        'konfrimasi_penduduk', 'tanggal_waktu_penduduk',
        'catatan_admin', 'catatan_penduduk',
        'tujuannya', 'tanggal_waktu',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
        'tanggal_waktu_admin' => 'datetime',
        'tanggal_waktu_penduduk' => 'datetime',
    ];

    public function settingsKunjungan()
    {
        return $this->belongsTo(SettingsKunjungan::class, 'id_settings_kunjungan', 'id_settings_kunjungan');
    }

        public function pemohon()
    {
        return $this->belongsTo(Pemohon::class, 'id_pemohon', 'id_pemohon');
    }

    // Status gabungan: dipakai di daftar dan detail
    public function getStatusAttribute(): string
    {
        if ($this->konfrimasi_admin === 'T' || $this->konfrimasi_penduduk === 'T') {
            return 'ditolak';
        }

        if ($this->konfrimasi_admin === 'Y' && $this->konfrimasi_penduduk === 'Y') {
            return 'disetujui';
        }

        return 'menunggu';
    }
}