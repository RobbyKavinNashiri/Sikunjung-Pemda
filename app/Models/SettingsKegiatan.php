<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsKegiatan extends Model
{
    protected $table = 'settings_kegiatan';
    protected $primaryKey = 'id_settings_kegiatan';
    public $timestamps = false;

    protected $fillable = [
        'tanggal_awal', 'tanggal_akhir', 'id_jabatan_penduduk', 'kegiatan',
    ];

    protected $casts = [
        'tanggal_awal' => 'date',
        'tanggal_akhir' => 'date',
    ];

    public function jabatanPenduduk()
    {
        return $this->belongsTo(JabatanPenduduk::class, 'id_jabatan_penduduk', 'id_jabatan_penduduk');
    }
}