<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
class AbsensiController extends Controller
{
    /**
     * Display the QR code scanning page.
     */


    public function scan($kegiatan_id)
    {
        // Fetch the kegiatan data
        $kegiatan = Kegiatan::find($kegiatan_id);

        if (!$kegiatan) {
            abort(404, 'Kegiatan tidak ditemukan.');
        }

        // Eager load the absensi data and associated user and kegiatan
        $absensi = Absensi::where('kegiatan_id', $kegiatan_id)
                        ->with('user', 'kegiatan') // Eager load the related user and kegiatan
                        ->get();

        return view('absensi.scan', compact('kegiatan', 'absensi')); // Pass both kegiatan and absensi to the view
    }

    /**
     * Handle the QR Code validation and attendance.
     */
    public function validasiQr(Request $request)
    {
        // Find the kegiatan by ID
        $kegiatan = Kegiatan::find($request->kegiatan_id);

        // Check if kegiatan exists
        if (!$kegiatan) {
            return response()->json(['status_error' => 'Kegiatan tidak ditemukan']);
        }

        // Process the QR code data (Assuming `qr_code` contains NIM or user identifier)
        $user = User::where('nim', $request->qr_code)->first();

        if ($user) {
            // Check if the user has already attended this kegiatan
            $existingAbsensi = Absensi::where('user_id', $user->id)
                ->where('kegiatan_id', $kegiatan->id)
                ->first();

            // If the attendance already exists and the status is 'hadir', return an error
            if ($existingAbsensi && $existingAbsensi->status == 'hadir') {
                return response()->json([
                    'berhasil' => false,
                    'status_error' => 'Anda sudah melakukan absensi untuk kegiatan ini.'
                ]);
            }

            // If no attendance exists or the status is not 'hadir', proceed with updating or creating the record
            if ($existingAbsensi) {
                // If the attendance already exists but the status is not 'hadir', update the status
                $existingAbsensi->status = 'hadir';  // Update status to 'hadir'
                $existingAbsensi->save(); // Save the updated record
            } else {
                // If no attendance exists, create a new record
                Absensi::create([
                    'user_id' => $user->id,
                    'kegiatan_id' => $kegiatan->id,
                    'status' => 'hadir',  // Status set to 'hadir'
                ]);
            }

            // Return success response with necessary data, including kegiatan name
            return response()->json([
                'berhasil' => true,
                'name' => $user->name,
                'nim' => $user->nim,
                'kegiatan' => $kegiatan->nama_kegiatan,  // Return the kegiatan name
            ]);
        } else {
            return response()->json(['status_error' => 'Pengguna tidak ditemukan']);
        }
    }


    /**
     * Proses absensi untuk pengguna.
     */
    public function prosesAbsensi(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'qr_code' => 'required|string|max:255',
            'kegiatan_id' => 'required|exists:kegiatans,id', // Validate kegiatan ID
        ]);

        $qrCode = $validated['qr_code'];
        $kegiatanId = $validated['kegiatan_id'];

        try {
            // Search user based on QR Code or NIM
            $user = User::where('qr_code', $qrCode)
                        ->orWhere('nim', $qrCode)
                        ->first();

            if (!$user) {
                return response()->json([
                    'status_error' => 'QR Code atau NIM tidak valid.',
                ], 400);
            }

            // Check if attendance has already been recorded for this user and activity (kegiatan)
            $existingAbsensi = Absensi::where('user_id', $user->id)
                                      ->where('kegiatan_id', $kegiatanId)
                                      ->first();

            if ($existingAbsensi) {
                return response()->json([
                    'status_error' => 'Absensi sudah tercatat untuk kegiatan ini.',
                ], 400);
            }

            // Record attendance for the selected activity with default 'tidak_hadir' status
            Absensi::create([
                'user_id' => $user->id,
                'kegiatan_id' => $kegiatanId,
                'status' => 'tidak_hadir', // Default status set to 'tidak_hadir'
            ]);

            // Retrieve the activity name using the kegiatan_id
            $kegiatan = Kegiatan::find($kegiatanId);

            return response()->json([
                'berhasil' => true,
                'name' => $user->name,
                'nim' => $user->nim,
                'kegiatan' => $kegiatan ? $kegiatan->nama_kegiatan : 'Kegiatan tidak ditemukan', // Ensure valid kegiatan name is passed
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_error' => 'Terjadi kesalahan saat mencatat absensi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mencatat absensi untuk pengguna pada suatu kegiatan.
     */
    private function recordAttendance(User $user, Kegiatan $kegiatan)
    {
        Absensi::create([
            'user_id' => $user->id,
            'kegiatan_id' => $kegiatan->id,
            'status' => 'hadir', // Status absensi, bisa disesuaikan jika diperlukan
        ]);
    }

    public function index()
{
    // Check if the user is an operator or admin
    if (auth()->user()->role !== 'operator' && auth()->user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    // Get all activities with attendance data, optimized by using counts for each attendance status
    $kegiatans = Kegiatan::withCount([
        'absensi as hadir_count' => function($query) {
            $query->where('status', 'hadir');
        },
        'absensi as tidak_hadir_count' => function($query) {
            $query->where('status', 'tidak_hadir');
        },
        'absensi as izin_count' => function($query) {
            $query->where('status', 'izin');
        }
    ])->get();

    // Get all users with the 'mahasiswa' role
    $users = User::where('role', 'mahasiswa')->get();

    return view('absensi.index', compact('kegiatans', 'users'));
}


    public function groups($kegiatanId, $kelompokId)
    {
        // Retrieve the 'kegiatan' with its absensi data and related users
        $kegiatan = Kegiatan::with(['absensi.user'])->findOrFail($kegiatanId);

        // Get the users who belong to the specified kelompok
        $users = User::where('kelompok', $kelompokId)->get();

        // Get the attendance records for the selected kegiatan
        $attended = $kegiatan->absensi->where('status', 'hadir')->pluck('user_id');
        $notAttended = $users->whereNotIn('id', $attended);

        // Return the view with the group details and attendance information
        return view('absensi.group_detail', compact('kegiatan', 'kelompokId', 'users', 'attended', 'notAttended'));
    }

    // Method to display detailed attendance for a specific group
    public function showGroups($kegiatanId)
    {
        // Find the kegiatan (activity) and eager load the absensi for this kegiatan
        $kegiatan = Kegiatan::findOrFail($kegiatanId);

        // Get all users with the 'mahasiswa' role and eager load their absensi for this kegiatan
        $users = User::with(['absensi' => function($query) use ($kegiatanId) {
            $query->where('kegiatan_id', $kegiatanId);
        }])->where('role', 'mahasiswa')->get();

        // Get all unique kelompok (groups) from users
        $kelompoks = User::select('kelompok')->distinct()->get(); // Adjust this query as per your actual grouping logic

        return view('absensi.groups', compact('kegiatan', 'users', 'kelompoks'));
    }

    // Method to display detailed attendance for a specific group
    public function showGroupDetail($kegiatanId, $kelompokId)
{
    // Retrieve the kegiatan (activity) with its attendance data and related users
    $kegiatan = Kegiatan::with(['absensi' => function($query) use ($kelompokId) {
        $query->whereHas('user', function($query) use ($kelompokId) {
            $query->where('kelompok', $kelompokId); // Filter users by kelompok
        });
    }])->findOrFail($kegiatanId);

    // Get the users who belong to the specified kelompok and have the "mahasiswa" role
    $users = User::where('kelompok', $kelompokId)
                 ->where('role', 'mahasiswa')
                 ->get();

    // Get the user_ids of the users who attended (status = 'hadir')
    $attendedUserIds = $kegiatan->absensi->where('status', 'hadir')->pluck('user_id')->toArray();

    // Get the user_ids of the users who are marked as "izin"
    $izinUserIds = $kegiatan->absensi->where('status', 'izin')->pluck('user_id')->toArray();

    // Get users who have not attended (not marked as 'hadir' or 'izin')
    $notAttended = $users->filter(function($user) use ($attendedUserIds, $izinUserIds) {
        return !in_array($user->id, $attendedUserIds) && !in_array($user->id, $izinUserIds);
    });

    // Count the total number of users in the group
    $totalUsersCount = $users->count();

    // Count the total number of users who attended
    $attendedCount = count($attendedUserIds);

    // Count the total number of users who did not attend (excluding "izin")
    $notAttendedCount = count($notAttended);

    // Count the total number of users who have "izin"
    $izinCount = count($izinUserIds);

    // Return the view with updated counts
    return view('absensi.group_detail', compact(
        'kegiatan',
        'kelompokId',
        'users',
        'attendedUserIds',
        'notAttended',
        'izinUserIds',
        'totalUsersCount',
        'attendedCount',
        'notAttendedCount',
        'izinCount'
    ));
}
public function updateAbsensi(Request $request, $kegiatan_id, $user_id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'status' => 'required|string|in:hadir,tidak_hadir,izin', // Ensure valid status
        ]);

        $status = $validated['status'];

        // Find the specific user and kegiatan
        $user = User::find($user_id);
        $kegiatan = Kegiatan::find($kegiatan_id);

        if (!$user || !$kegiatan) {
            return response()->json(['error' => 'User or Kegiatan not found'], 404);
        }

        // Find or create the attendance record
        $attendance = Absensi::where('user_id', $user->id)
                             ->where('kegiatan_id', $kegiatan->id)
                             ->first();

        if ($attendance) {
            // Update existing attendance record
            $attendance->status = $status;
            $attendance->save();
        } else {
            // Create a new attendance record
            Absensi::create([
                'user_id' => $user->id,
                'kegiatan_id' => $kegiatan->id,
                'status' => $status,
            ]);
        }

        // Return a success response
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $kegiatanId, $userId)
{
    // Validasi data yang dikirimkan
    $validated = $request->validate([
        'status' => 'required|string|in:hadir,tidak_hadir,izin',
    ]);

    // Temukan absensi berdasarkan kegiatan_id dan user_id
    $attendance = Absensi::where('kegiatan_id', $kegiatanId)
                         ->where('user_id', $userId)
                         ->first();

    if ($attendance) {
        // Update status absensi
        $attendance->status = $validated['status'];
        $attendance->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Absensi tidak ditemukan']);
}


public function card()
{
    // Retrieve all kegiatan (activities)
    $kegiatan = Kegiatan::all();

    // Return the 'absensi.card' view and pass the kegiatan data
    return view('absensi.card', compact('kegiatan'));
}


public function exportAbsensi($kegiatan_id, $kelompok)
{
    // Validasi peran pengguna
    if (auth()->user()->role !== 'operator' && auth()->user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    $user = auth()->user();
    $kegiatan = Kegiatan::findOrFail($kegiatan_id);

    // Ambil data absensi berdasarkan kegiatan dan kelompok operator
    $absensi = $kegiatan->absensi()->whereHas('user', function ($query) use ($kelompok) {
        $query->where('kelompok', $kelompok);
    })->get();

    // Ekspor ke Excel menggunakan Maatwebsite Excel
    return Excel::download(new AbsensiExport($absensi), 'absensi_kelompok_'.$kelompok.'_kegiatan_'.$kegiatan->id.'.xlsx');
}

}
