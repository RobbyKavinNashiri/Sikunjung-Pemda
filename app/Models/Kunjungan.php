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

    // ---------- Scope (potongan query yang bisa dipakai ulang) ----------

    /** Pengajuan milik satu pemohon. */
    public function scopeMilikPemohon($query, $idPemohon)
    {
        return $query->where('id_pemohon', $idPemohon);
    }

    /** Pengajuan yang ditujukan ke satu pejabat (lewat jadwal -> jabatan_penduduk). */
    public function scopeUntukPejabat($query, $idPenduduk)
    {
        return $query->whereHas('settingsKunjungan.jabatanPenduduk', fn ($q) => $q->where('id_penduduk', $idPenduduk));
    }

    // ---------- Helper ----------

    /** Status gabungan: admin DAN pejabat harus sama-sama setuju. Salah satu menolak = ditolak. */
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

    /** Pemohon hanya boleh mengubah/menghapus selama belum ada yang memutuskan. */
    public function bisaDiubah(): bool
    {
        return $this->konfrimasi_admin === null && $this->konfrimasi_penduduk === null;
    }
}
