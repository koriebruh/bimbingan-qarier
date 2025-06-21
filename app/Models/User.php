<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'name',
        'email',
        'alamat',
        'no_ktp',
        'no_hp',
        'poli_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'no_rm',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // Scope untuk dokter
    public function scopeDokter($query)
    {
        return $query->where('role', 'dokter');
    }

    // Scope untuk pasien
    public function scopePasien($query)
    {
        return $query->where('role', 'pasien');
    }

    // Relasi: Dokter memiliki banyak jadwal memeriksa.blade.php
    public function jadwalPeriksas()
    {
        return $this->hasMany(JadwalPeriksa::class, 'id_dokter');
    }

    // Relasi: Pasien memiliki banyak janji memeriksa.blade.php
    public function janjiPeriksas()
    {
        return $this->hasMany(JanjiPeriksa::class, 'id_pasien');
    }

    // Helper method untuk cek apakah user adalah dokter
    public function isDokter()
    {
        return $this->role === 'dokter';
    }

    // Helper method untuk cek apakah user adalah pasien
    public function isPasien()
    {
        return $this->role === 'pasien';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }


    // GNEERATED FOORMATING NO REKAM MEDIS
    public static function generateNoRmFromId($id)
    {
        $now = now();
        $prefix = $now->format('Ym');
        return $prefix . '-' . $id;
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->no_rm = self::generateNoRmFromId($user->id);

            if ($user->isDokter() || $user->isAdmin()) {
                $user->no_rm = null;
            }

            $user->save();
        });
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }
}
