<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsKunjungan extends Model
{
    protected $table = 'settings_kunjungan';
    protected $primaryKey = 'id_settings_kunjungan';
    public $timestamps = false;

    protected $fillable = [
        'id_jabatan_penduduk', 'tanggal', 'jam_aktif', 'jam_non_aktif', 'status',
    ];

    protected $casts = ['tanggal' => 'date'];

    public function jabatanPenduduk()
    {
        return $this->belongsTo(JabatanPenduduk::class, 'id_jabatan_penduduk', 'id_jabatan_penduduk');
    }

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'id_settings_kunjungan', 'id_settings_kunjungan');
    }

    // ---------- Scope ----------

    /** Jadwal yang dibuka (status Y). */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Y');
    }

    /** Jadwal hari ini dan seterusnya. */
    public function scopeMendatang($query)
    {
        return $query->whereDate('tanggal', '>=', now()->toDateString());
    }

    /** Jadwal milik satu pejabat. */
    public function scopeMilikPejabat($query, $idPenduduk)
    {
        return $query->whereHas('jabatanPenduduk', fn ($q) => $q->where('id_penduduk', $idPenduduk));
    }
}
