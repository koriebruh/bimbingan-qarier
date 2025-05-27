<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JanjiPeriksa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pasien',
        'id_jadwal',
        'keluhan',
        'no_antrian',
    ];

    protected $casts = [
        'no_antrian' => 'integer',
    ];

    // Relasi: Janji memeriksa.blade.php belongs to pasien (user)
    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    // Relasi: Janji memeriksa.blade.php belongs to jadwal memeriksa.blade.php
    public function jadwalPeriksa()
    {
        return $this->belongsTo(JadwalPeriksa::class, 'id_jadwal');
    }

    // Relasi: Janji memeriksa.blade.php has one memeriksa.blade.php
    public function periksa()
    {
        return $this->hasOne(Periksa::class, 'id_janji_periksa');
    }

    // Accessor untuk mendapatkan dokter melalui jadwal memeriksa.blade.php
    public function getDokterAttribute()
    {
        return $this->jadwalPeriksa->dokter ?? null;
    }

    // Scope untuk mendapatkan janji memeriksa.blade.php yang belum diperiksa
    public function scopeBelumDiperiksa($query)
    {
        return $query->whereDoesntHave('memeriksa.blade.php');
    }

    // Scope untuk mendapatkan janji memeriksa.blade.php yang sudah diperiksa
    public function scopeSudahDiperiksa($query)
    {
        return $query->whereHas('memeriksa.blade.php');
    }
}
