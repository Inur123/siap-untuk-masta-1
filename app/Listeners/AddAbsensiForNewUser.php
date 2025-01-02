<?php

namespace App\Listeners;

use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddAbsensiForNewUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;

        // Ambil semua kegiatan yang ada
        $kegiatans = Kegiatan::all();

        foreach ($kegiatans as $kegiatan) {
            // Pastikan absensi belum ada untuk pengguna dan kegiatan ini
            Absensi::firstOrCreate([
                'user_id' => $user->id,
                'kegiatan_id' => $kegiatan->id,
            ], [
                'status' => 'tidak_hadir', // Status default untuk absensi
                'tanggal' => now()->toDateString(), // Tanggal absensi
            ]);
        }
    }
}
