<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_janji_periksa',
        'tgl_periksa',
        'catatan',
        'biaya_periksa',
    ];

    protected $casts = [
        'tgl_periksa' => 'datetime',
        'biaya_periksa' => 'integer',
    ];

    // Relasi: Periksa belongs to janji memeriksa.blade.php
    public function janjiPeriksa()
    {
        return $this->belongsTo(JanjiPeriksa::class, 'id_janji_periksa');
    }

    // Relasi: Periksa memiliki banyak detail memeriksa.blade.php
    public function detailPeriksas()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_periksa');
    }

    // Relasi: Many-to-many dengan obat melalui detail_periksas
    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'detail_periksas', 'id_periksa', 'id_obat');
    }

    // Accessor untuk mendapatkan pasien melalui janji memeriksa.blade.php
    public function getPasienAttribute()
    {
        return $this->janjiPeriksa->pasien ?? null;
    }

    // Accessor untuk mendapatkan dokter melalui janji memeriksa.blade.php
    public function getDokterAttribute()
    {
        return $this->janjiPeriksa->dokter ?? null;
    }

    // Accessor untuk format biaya
    public function getFormattedBiayaAttribute()
    {
        return 'Rp ' . number_format($this->biaya_periksa, 0, ',', '.');
    }

    // Method untuk menghitung total biaya obat
    public function getTotalBiayaObatAttribute()
    {
        return $this->obats->sum('harga');
    }

    // Method untuk menghitung total biaya keseluruhan
    public function getTotalBiayaAttribute()
    {
        return $this->biaya_periksa + $this->total_biaya_obat;
    }
}
