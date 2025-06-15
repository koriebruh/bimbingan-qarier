<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'message',
        'sender_role',
        'is_edited',
    ];

    // Relasi ke User (Pasien)
    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    // Relasi ke User (Dokter)
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Asia/Jakarta');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Asia/Jakarta');
    }

}
