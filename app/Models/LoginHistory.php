<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    use HasFactory;

    // Menyebutkan nama tabel jika berbeda dengan nama model (login_histories)
    protected $table = 'login_history';

    // Kolom yang dapat diisi
    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'login_time'];

    // Relasi dengan tabel User (jika diperlukan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
