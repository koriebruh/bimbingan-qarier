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

    // Relasi: Janji periksa belongs to pasien (user)
    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    // Relasi: Janji periksa belongs to jadwal periksa
    public function jadwalPeriksa()
    {
        return $this->belongsTo(JadwalPeriksa::class, 'id_jadwal');
    }

    // Relasi: Janji periksa has one periksa
    public function periksa()
    {
        return $this->hasOne(Periksa::class, 'id_janji_periksa');
    }

    // Accessor untuk mendapatkan dokter melalui jadwal periksa
    public function getDokterAttribute()
    {
        return $this->jadwalPeriksa->dokter ?? null;
    }

    // Scope untuk mendapatkan janji periksa yang belum diperiksa
    public function scopeBelumDiperiksa($query)
    {
        return $query->whereDoesntHave('periksa');
    }

    // Scope untuk mendapatkan janji periksa yang sudah diperiksa
    public function scopeSudahDiperiksa($query)
    {
        return $query->whereHas('periksa');
    }
}
