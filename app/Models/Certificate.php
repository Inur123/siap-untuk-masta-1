<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'certificate_image', 'is_generated'];

    // Relasi dengan User (Setiap certificate dimiliki oleh satu user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
