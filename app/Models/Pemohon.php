<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pemohon extends Authenticatable
{
    protected $table = 'pemohon';
    protected $primaryKey = 'id_pemohon';
    public $timestamps = false;

    protected $fillable = ['nama', 'telepon', 'email', 'password'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'id_pemohon', 'id_pemohon');
    }
}