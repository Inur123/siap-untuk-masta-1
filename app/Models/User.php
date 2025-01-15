<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nim',
        'fakultas',
        'prodi',
        'file',
        'kelompok',  // Pastikan kolom ini ada di tabel user untuk menandakan kelompok
        'role',
        'nohp',
        'alamat',
        'jeniskelamin',
        'qr_code',
        'absensi_progress', // Add this to the fillable array

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 10+ hashed casting
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class); // Relasi hasMany ke Absensi
    }
    /**
     * Relasi dengan Group (kelompok) - Setiap User hanya memiliki satu Group
     */
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function loginHistory()
    {
        return $this->hasMany(LoginHistory::class);
    }

}
