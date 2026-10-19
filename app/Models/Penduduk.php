<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Penduduk extends Authenticatable
{
    protected $table = 'penduduk';
    protected $primaryKey = 'id_penduduk';
    public $timestamps = false;

    protected $fillable = [
        'nama_penduduk', 'nik', 'kk', 'jenis_kelamin',
        'alamat', 'username', 'password', 'status',
    ];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function jabatanPenduduk()
    {
        return $this->hasMany(JabatanPenduduk::class, 'id_penduduk', 'id_penduduk');
    }
}