<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPeriksa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    protected $casts = [
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    // Relasi: Jadwal memeriksa.blade.php belongs to dokter (user)
    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }

    // Relasi: Jadwal memeriksa.blade.php memiliki banyak janji memeriksa.blade.php
    public function janjiPeriksas()
    {
        return $this->hasMany(JanjiPeriksa::class, 'id_jadwal');
    }

    // Accessor untuk format jam
    public function getJamPraktikAttribute()
    {
        return $this->jam_mulai->format('H:i') . ' - ' . $this->jam_selesai->format('H:i');
    }
}
