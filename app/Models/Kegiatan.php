<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    // Nama tabel jika tidak mengikuti pluralisasi
    protected $table = 'kegiatan'; // Hanya jika nama tabel tidak mengikuti konvensi plural

    // Kolom yang dapat diisi
    protected $fillable = ['nama_kegiatan', 'tanggal'];

    /**
     * Relasi dengan tabel absensi
     * Satu kegiatan dapat memiliki banyak absensi.
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'kegiatan_id', 'id'); // Relasi hasMany ke Absensi
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
