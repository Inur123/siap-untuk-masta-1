<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Models\User;
use App\Models\Absensi;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;// Pastikan model User sudah ada

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:mahasiswa']);
    }

    /**
     * Show the mahasiswa dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user(); // Retrieve the authenticated user

        // Find the operator associated with the student's group
        $operator = User::where('kelompok', $user->kelompok)
            ->where('role', 'operator')
            ->first();
        $announcements = Announcement::where('role', 'mahasiswa')
            ->where('is_active', true)  // Filter by active status
            ->latest()
            ->get();
        $qrCodeUrl = asset('storage/' . $user->qr_code);
        return view('mahasiswa.dashboard', compact('user', 'operator','announcements','qrCodeUrl')); // Pass both user and operator data to the view
    }


    // Show the form for editing the authenticated user's data
    public function edit()
    {
        $user = Auth::user();

        $encryptedUserId = Crypt::encryptString($user->id);
        // Get the authenticated user
        return view('mahasiswa.edit', compact('user','encryptedUserId')); // Pass the user data to the view
    }

    public function update(Request $request)
{
    $user = Auth::user(); // Get the authenticated user

    // Adjust the validation rules as per your requirements
    $request->validate([
        'name' => ['nullable', 'string', 'max:255'], // Allow nullable
        'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        'nim' => ['nullable', 'string', 'unique:users,nim,' . $user->id],
        'fakultas' => ['nullable', 'string', 'max:255'],
        'prodi' => ['nullable', 'string', 'max:255'],
        'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'], // Make file optional
        'current_password' => ['nullable', 'string', 'min:8'], // Optional current password for validation
        'new_password' => ['nullable', 'string', 'min:8', 'confirmed'], // New password and confirmation
    ]);

    // Prepare data array for update
    $data = [];

    // Update user fields only if provided
    if ($request->filled('name')) {
        $data['name'] = $request->name;
    }

    if ($request->filled('email')) {
        $data['email'] = $request->email;
    }

    if ($request->filled('nim')) {
        $data['nim'] = $request->nim;
    }

    if ($request->filled('fakultas')) {
        $data['fakultas'] = $request->fakultas;
    }

    if ($request->filled('prodi')) {
        $data['prodi'] = $request->prodi;
    }

    // Handle file upload if provided
    if ($request->hasFile('file')) {
        // Check if the user has an existing file
        if ($user->file) {
            Storage::delete('public/' . $user->file);
        }
        // Store the new file and update the data array
        $data['file'] = $request->file('file')->store('uploads', 'public');
    }

    // Update user data
    if (!empty($data)) { // Only update if there's any data to update
        $user->update($data);
    }

    // If new password is provided, validate current password and update it
    if ($request->filled('new_password')) {
        // Check if the current password matches the stored password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the password
        $user->update(['password' => Hash::make($request->new_password)]);
    }

    return redirect()->route('mahasiswa.dashboard')->with('success', 'Data updated successfully.');
}

public function getAnnouncementsByRole()
{
    $role = auth()->user()->role;  // Ambil role dari pengguna yang sedang login

    // Ambil pengumuman untuk role 'mahasiswa'
    $announcements = Announcement::where('role', $role)->latest()->get();

    return view('mahasiswa.dashboard', compact('announcements'));
}


public function absensi()
{
    // Get the authenticated student (mahasiswa)
    $user = Auth::user();

    // Fetch the attendance data for the student (mahasiswa) for all kegiatan
    $absensi = Absensi::where('user_id', $user->id)
        ->with('kegiatan')  // Eager load the related 'kegiatan' (event)
        ->latest()
        ->get();

    // Calculate the total number of activities
    $totalKegiatan = $absensi->count();

    // Calculate the number of 'hadir' (present) attendance records
    $hadirCount = $absensi->where('status', 'hadir')->count();

    // Calculate the attendance percentage
    if ($totalKegiatan > 0) {
        $percentage = ($hadirCount / $totalKegiatan) * 100;
    } else {
        $percentage = 0;
    }

    // Apply a specific rule: If there are 3 activities and 2 are present, set percentage to 85%
    if ($totalKegiatan == 3 && $hadirCount == 2) {
        $percentage = 85;
    }

    // Update the user's attendance percentage in the database
    $user->update([
        'absensi_progress' => $percentage,
    ]);

    // Return the view with the attendance data and percentage
    return view('mahasiswa.absensi', compact('absensi', 'percentage'));
}



}
