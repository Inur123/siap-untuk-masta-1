<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Menampilkan daftar kegiatan.
     */
    public function index()
    {
        $kegiatans = Kegiatan::all();
        return view('kegiatan.index', compact('kegiatans'));
    }

    /**
     * Menampilkan form untuk menambah kegiatan.
     */
    public function create()
    {
        return view('kegiatan.create'); // Halaman form untuk menambah kegiatan
    }

    /**
     * Menyimpan data kegiatan baru.
     */
    public function store(Request $request)
    {
        // Validasi input untuk nama kegiatan saja
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
        ]);

        // Membuat kegiatan baru dengan tanggal otomatis hari ini
        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal' => now()->toDateString(), // Mengisi tanggal dengan hari ini
        ]);

        // Ambil semua mahasiswa
        $mahasiswa = User::where('role', 'mahasiswa')->get();

        // Menambahkan absensi untuk setiap mahasiswa dengan status 'tidak_hadir'
        foreach ($mahasiswa as $user) {
            Absensi::create([
                'user_id' => $user->id,
                'kegiatan_id' => $kegiatan->id,
                'status' => 'tidak_hadir', // Set default status ke 'tidak_hadir'
            ]);
        }

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan beserta absensi untuk mahasiswa.');
    }
}
