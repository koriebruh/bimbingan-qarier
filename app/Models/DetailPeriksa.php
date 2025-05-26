<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeriksa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_periksa',
        'id_obat',
    ];

    // Relasi: Detail periksa belongs to periksa
    public function periksa()
    {
        return $this->belongsTo(Periksa::class, 'id_periksa');
    }

    // Relasi: Detail periksa belongs to obat
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
