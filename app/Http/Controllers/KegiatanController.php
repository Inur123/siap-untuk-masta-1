<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;

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
        // Periksa apakah absensi sudah ada untuk kegiatan ini
        $absensi = Absensi::firstOrCreate([
            'user_id' => $user->id,
            'kegiatan_id' => $kegiatan->id,
        ], [
            'status' => 'tidak_hadir', // Set default status ke 'tidak_hadir'
            'tanggal' => now()->toDateString(), // Menyimpan tanggal absensi sesuai dengan kegiatan
        ]);
    }

    return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan beserta absensi untuk mahasiswa.');
}

    public function edit($id)
    {
        // Ambil kegiatan berdasarkan ID
        $kegiatan = Kegiatan::findOrFail($id);

        // Tampilkan halaman edit dengan data kegiatan
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
        ]);

        // Cari kegiatan berdasarkan ID dan update data
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal' => $request->tanggal, // Update tanggal jika diperlukan
        ]);

        // Redirect ke halaman daftar kegiatan dengan pesan sukses
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari dan hapus kegiatan berdasarkan ID
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        // Redirect ke halaman daftar kegiatan dengan pesan sukses
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function exportAbsensi(Request $request)
    {
        // Validasi peran pengguna
        if (auth()->user()->role !== 'operator' && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        $kegiatanId = $request->get('kegiatan_id');
        $kelompok = $request->get('kelompok');

        // Admin dapat memilih kegiatan dan kelompok
        if ($user->role === 'admin') {
            $kegiatan = Kegiatan::findOrFail($kegiatanId);

            // Jika memilih kelompok tertentu
            if ($kelompok !== 'all') {
                // Ambil data absensi berdasarkan kegiatan dan kelompok
                $absensi = $kegiatan->absensi()->whereHas('user', function ($query) use ($kelompok) {
                    $query->where('kelompok', $kelompok);
                })->get();
            } else {
                // Jika memilih seluruh data (tidak filter berdasarkan kelompok)
                $absensi = $kegiatan->absensi()->get();
            }
        }
        // Operator hanya dapat memilih berdasarkan kelompok
        elseif ($user->role === 'operator') {
            // Ambil data absensi berdasarkan kelompok
            $absensi = Absensi::whereHas('user', function ($query) use ($kelompok) {
                $query->where('kelompok', $kelompok);
            })->get();
        }

        // Ekspor ke Excel menggunakan Maatwebsite Excel
        return Excel::download(new AbsensiExport($absensi), 'absensi.xlsx');
    }


}
