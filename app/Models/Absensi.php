<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';  // Ensure you're using the correct table

    protected $fillable = [
        'user_id',
        'kegiatan_id',
        'status',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Kegiatan model
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }
}
