<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $primaryKey = 'id_jabatan';
    public $timestamps = false;

    protected $fillable = ['nama_jabatan'];

    public function jabatanPenduduk()
    {
        return $this->hasMany(JabatanPenduduk::class, 'id_jabatan', 'id_jabatan');
    }
}