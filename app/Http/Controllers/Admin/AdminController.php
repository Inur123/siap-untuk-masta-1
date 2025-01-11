<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Exports\UsersExport;
use App\Models\Announcement;
use Illuminate\Http\Request;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Font;
use Illuminate\Support\Facades\DB;

use App\Exports\GroupMembersExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\Style\Paragraph;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        // Hitung total user berdasarkan role
        $user = auth()->user();
        $totalUsers = User::count(); // Total semua user
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalOperator = User::where('role', 'operator')->count();
        $totalGroups = User::whereNotNull('kelompok') // Ensure kelompok is not null
        ->distinct('kelompok') // Get distinct kelompok values
        ->count('kelompok'); // Count the number of unique kelompok values
        // Calculate the total number of members in each faculty (fakultas)
        $totalMembersPerFakultas = User::where('role', 'mahasiswa')
            ->select('fakultas', DB::raw('count(*) as total'))
            ->groupBy('fakultas')
            ->get()
            ->keyBy('fakultas');

        // Retrieve the latest group data from the database
        $groupData = User::where('role', 'mahasiswa')
            ->whereNotNull('kelompok')
            ->select('fakultas', 'kelompok', DB::raw('count(*) as total'))
            ->groupBy('fakultas', 'kelompok')
            ->get()
            ->groupBy('fakultas')
            ->map(function ($groups) {
                return $groups->pluck('total', 'kelompok')->toArray();
            });

        // Calculate total groups per faculty
        $totalGroupsPerFakultas = $groupData->map(function ($groups) {
            return count($groups);
        });

        // Retrieve user registration data for the week (Monday to Sunday)
        $registrations = User::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->startOfWeek()) // Start of the week (Monday)
            ->where('created_at', '<=', now()->endOfWeek()) // End of the week (Sunday)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Kirim data ke view
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalMahasiswa',
            'totalAdmin',
            'totalOperator',
            'groupData',
            'totalMembersPerFakultas',
            'totalGroupsPerFakultas',
            'registrations',
            'totalGroups',
            'user' // Pass the retrieved registrations data to the view
        ));
    }


    /**
     * Show all users.
     */
    public function showAllUsers()
    {

        $admin = User::where('role', 'admin')->get();

        return view('admin.users', compact('admin'));
    }

    /**
     * Assign users to groups dynamically.
     */
    public function assignGroups()
    {
        // Retrieve all 'mahasiswa' users who are not yet assigned to a group
        $users = User::where('role', 'mahasiswa')->whereNull('kelompok')->get();

        // Find the highest existing group index to continue numbering correctly
        $lastGroupIndex = User::where('role', 'mahasiswa')
            ->whereNotNull('kelompok')
            ->max(DB::raw('CAST(kelompok AS UNSIGNED)')) ?? 0;

        // Start assigning groups from the next available index
        $globalGroupIndex = $lastGroupIndex + 1;

        // Group existing mahasiswa users by fakultas
        $existingGroups = User::where('role', 'mahasiswa')
            ->whereNotNull('kelompok')
            ->get()
            ->groupBy('fakultas');

        // Initialize an array to track the count of members in each group for round-robin assignment
        $groupStatus = [];

        // Populate the group status with existing groups
        foreach ($existingGroups as $fakultas => $mahasiswa) {
            $groupedByKelompok = $mahasiswa->groupBy('kelompok');
            foreach ($groupedByKelompok as $kelompok => $groupMembers) {
                $count = $groupMembers->count();
                $groupStatus[$fakultas][$kelompok] = $count; // Track the number of members in each group
            }
        }

        // Assign new users to groups in a round-robin manner
        foreach ($users as $user) {
            // Determine the faculty of the user
            $fakultas = $user->fakultas;

            // Check if the faculty has existing groups
            if (isset($groupStatus[$fakultas])) {
                // Find the next available group in the round-robin manner
                $assigned = false;
                foreach ($groupStatus[$fakultas] as $kelompok => $memberCount) {
                    if ($memberCount < 10) {
                        // Assign to the first available group with fewer than 10 members
                        $user->kelompok = $kelompok;
                        $user->save();
                        $groupStatus[$fakultas][$kelompok]++; // Increment the member count for this group
                        $assigned = true;
                        break; // Exit the loop once assigned
                    }
                }

                // If no available group was found, create a new one with the global index
                if (!$assigned) {
                    $user->kelompok = $globalGroupIndex; // Use the global group index
                    $user->save();

                    // Initialize the new group in the status
                    $groupStatus[$fakultas][$globalGroupIndex] = 1; // Start with 1 member
                    $globalGroupIndex++; // Increment the global group index for the next group
                }
            } else {
                // If there are no existing groups for this faculty, create a new group with the global index
                $user->kelompok = $globalGroupIndex; // Assign to the next global group
                $user->save();

                // Initialize the new group in the status
                $groupStatus[$fakultas][$globalGroupIndex] = 1; // Start with 1 member
                $globalGroupIndex++; // Increment for future groups
            }
        }

        return redirect()->route('admin.users')
            ->with('success', 'Mahasiswa users have been assigned to groups successfully!');
    }



    public function clearGroups()
    {
        // Clear group data only for 'mahasiswa' users
        User::where('role', 'mahasiswa')->update(['kelompok' => null]);

        return redirect()->route('admin.users')->with('success', 'Group data for mahasiswa users has been cleared successfully!');
    }

    public function clearMahasiswa()
{
    // Retrieve all 'mahasiswa' users
    $mahasiswaUsers = User::where('role', 'mahasiswa')->get();

    foreach ($mahasiswaUsers as $user) {
        // Delete file if it exists
        if ($user->file) {
            Storage::delete($user->file);
        }

        // Delete the user
        $user->delete();
    }

    return redirect()->route('admin.users')->with('success', 'All mahasiswa users and their data have been cleared successfully!');
}

    /**
     * Show the edit form for a user.
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    /**
     * Update a user in the database.
     */
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,operator,mahasiswa',
            'nim' => 'nullable|string',
            'fakultas' => 'nullable|string',
            'prodi' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kelompok' => 'nullable|string',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Handle file upload
        if ($request->hasFile('file')) {
            if (!empty($user->file)) {
                Storage::delete($user->file);
            }
            $user->file = $request->file('file')->store('files');
        }

        $user->nim = $request->nim;
        $user->fakultas = $request->fakultas;
        $user->prodi = $request->prodi;
        $user->kelompok = $request->kelompok;

        $user->save();

        return redirect()->route('admin.mahasiswa')->with('success', 'User updated successfully!');
    }

    /**
     * Delete a user from the database.
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->file) {
            Storage::delete($user->file);
        }
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }


    //create data operator
    public function createOperator()
{
    return view('admin.create_operator'); // Create a view for the form
}
/**
 * Store a newly created operator in the database.
 */
public function storeOperator(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'nim' => 'required|string|max:50', // NIM validation
        'email' => 'required|email|unique:users',
        'kelompok' => 'nullable|string',
        'fakultas' => 'nullable|string',
        'prodi' => 'nullable|string',
        'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // File is required
    ]);

    // Handle file upload before creating the user
    $filePath = $request->file('file')->store('files');

    // Prepare the data for user creation
    $data = [
        'name' => $request->name,
        'nim' => $request->nim,
        'email' => $request->email,
        'password' => bcrypt('password'), // Set default password
        'role' => 'operator', // Default role is operator
        'kelompok' => $request->kelompok,
        'fakultas' => $request->fakultas,
        'prodi' => $request->prodi,
        'file' => $filePath, // Include file path in user data
    ];

    // Create the user with the file path included
    User::create($data);

    return redirect()->route('admin.users')->with('success', 'Pemandu created successfully!');
}

public function editOperator($id)
{
    $operator = User::findOrFail($id); // Ambil data operator berdasarkan ID
    return view('admin.edit_operator', compact('operator')); // Tampilkan view edit
}
public function destroyOperator($id)
{
    // Find the operator by ID or fail if not found
    $operator = User::findOrFail($id);

    // Delete the operator from the database
    $operator->delete();

    // Redirect back with a success message
    return redirect()->route('admin.operators')->with('success', 'Pemandu deleted successfully!');
}

public function updateOperator(Request $request, $id)
{
    // Ambil data operator yang ingin diperbarui
    $operator = User::findOrFail($id);

    // Validasi data input
    $request->validate([
        'name' => 'required|string|max:255',
        'nim' => 'required|string|max:50',
        'email' => 'required|email|unique:users,email,' . $id, // Abaikan email saat ini
        'kelompok' => 'nullable|string',
        'fakultas' => 'nullable|string',
        'prodi' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // File opsional
    ]);

    // Update data operator
    $data = $request->only(['name', 'nim', 'email', 'kelompok', 'fakultas', 'prodi']);

    // Cek jika ada file baru yang diupload
    if ($request->hasFile('file')) {
        // Upload file baru
        $filePath = $request->file('file')->store('files');

        // Hapus file lama jika ada
        if ($operator->file) {
            Storage::delete($operator->file);
        }

        // Tambahkan path file baru ke data
        $data['file'] = $filePath;
    }

    // Update data operator
    $operator->update($data);

    return redirect()->route('admin.operators')->with('success', 'Operator updated successfully!');
}


// Menampilkan form untuk membuat pengumuman
public function createAnnouncement()
{
    // Mengambil semua pengumuman, atau bisa disesuaikan jika perlu
    $announcements = Announcement::all();

    // Kembalikan view create_announcement.blade.php
    return view('admin.create_announcement', compact('announcements'));
}

// Menyimpan pengumuman baru
public function storeAnnouncement(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'role' => 'required|in:operator,mahasiswa',
    ]);

    // Membuat pengumuman baru dan menyimpannya di database
    Announcement::create($request->only('title', 'content', 'role'));

    // Redirect ke halaman create announcement dengan pesan sukses
    return redirect()->route('admin.create_announcement')->with('success', 'Announcement created successfully!');
}

// Mendapatkan pengumuman berdasarkan role (admin hanya mengelola pengumuman mahasiswa)
public function getAnnouncementsByRole()
{
    $role = auth()->user()->role; // Mendapatkan role dari user yang login

    // Ambil pengumuman berdasarkan role yang sedang aktif
    $announcements = Announcement::where('role', $role)->where('is_active', true)->latest()->get();

    // Kirimkan pengumuman ke view dashboard admin
    return view('admin.dashboard', compact('announcements'));
}

// Mengubah status aktif/tidak aktif pengumuman
public function toggleAnnouncementStatus($id)
{
    // Mencari pengumuman berdasarkan ID
    $announcement = Announcement::findOrFail($id);

    // Toggle status 'is_active' pengumuman
    $announcement->is_active = !$announcement->is_active;
    $announcement->save();

    // Redirect kembali dengan pesan sukses
    return redirect()->route('admin.create_announcement')->with('success', 'Announcement status updated successfully!');
}

// Menghapus pengumuman
public function destroyAnnouncement($id)
{
    // Cari pengumuman berdasarkan ID dan hapus
    $announcement = Announcement::findOrFail($id);
    $announcement->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.create_announcement')->with('success', 'Announcement deleted successfully!');
}

// Mengupdate pengumuman
public function updateAnnouncement(Request $request, $id)
{
    // Validasi data yang diterima
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'role' => 'required|in:operator,mahasiswa',
    ]);

    // Mencari pengumuman berdasarkan ID
    $announcement = Announcement::findOrFail($id);

    // Update pengumuman dengan data yang baru
    $announcement->update($request->only('title', 'content', 'role'));

    // Redirect ke halaman create_announcement dengan pesan sukses
    return redirect()->route('admin.create_announcement')->with('success', 'Announcement updated successfully!');
}

public function showOperators()
{
    // Get all users with role 'operator'
    $operators = User::where('role', 'operator')->get(); // You can adjust the condition if needed

    // Return view with operator data
    return view('admin.operators', compact('operators'));
}

public function showMahasiswa()
{
    // Get all users with role 'operator'
    $mahasiswa = User::where('role', 'mahasiswa')->get(); // You can adjust the condition if needed

    // Return view with operator data
    return view('admin.mahasiswa', compact('mahasiswa'));
}

public function showGroups()
{
    // Ambil semua data mahasiswa dengan informasi kelompok, fakultas, nim, nama, dan prodi
    $groups = User::select('kelompok', 'fakultas', 'nim', 'name', 'prodi')
                  ->where('role', 'mahasiswa')  // Filter hanya mahasiswa
                  ->get(); // Ambil semua data tanpa batasan

    // Gunakan collection untuk mengelompokkan data berdasarkan 'kelompok'
    $groupDetails = $groups->groupBy('kelompok');

    // Loop untuk mendapatkan anggota berdasarkan kelompok
    foreach ($groupDetails as $kelompok => $group) {
        // Tambahkan data anggota untuk setiap kelompok
        $groupDetails[$kelompok] = [
            'kelompok' => $kelompok,
            'fakultas' => $group->first()->fakultas, // Ambil fakultas dari anggota pertama
            'members' => $group, // Anggota yang sudah dikelompokkan berdasarkan 'kelompok'
            'memberCount' => $group->count() // Tambahkan jumlah anggota dalam kelompok
        ];
    }

    // Pass groupDetails ke view
    return view('admin.groups', ['groupDetails' => $groupDetails]);
}




public function showGroupDetail($kelompok)
{
    // Ambil semua anggota dalam kelompok tersebut
    $groupMembers = User::where('kelompok', $kelompok)
                        ->where('role', 'mahasiswa')
                        ->get();

    // Jika kelompok tidak ada anggota, redirect ke halaman groups
    if ($groupMembers->isEmpty()) {
        return redirect()->route('admin.groups')->with('error', 'Kelompok tidak ditemukan atau kosong.');
    }

    // Ambil detail kelompok lainnya (seperti fakultas, dll) jika diperlukan
    $groupDetail = $groupMembers->first(); // Misalnya menggunakan anggota pertama untuk mendapatkan fakultas atau data lainnya

    // Ambil Nama Pemandu dan Nomor HP Pemandu (dari user dengan role 'operator' yang memiliki kelompok yang sama)
    $operator = User::where('role', 'operator')
                    ->where('kelompok', $kelompok) // Pastikan operator dalam kelompok yang sama
                    ->first();

    // Jika tidak ada operator untuk kelompok ini, bisa diatur untuk tampilkan pesan atau nilai default
    $pemanduName = $operator ? $operator->name : 'Belum ada pemandu';
    $pemanduPhone = $operator ? $operator->nohp : 'N/A';

    // Kirim data kelompok, anggota, dan pemandu ke view
    return view('admin.groupDetail', compact('groupMembers', 'groupDetail', 'pemanduName', 'pemanduPhone'));
}

// Export functionality for the specific group
public function exportGroupMembersToExcel($kelompok)
{
    return Excel::download(new GroupMembersExport($kelompok), 'group_'.$kelompok.'_members.xlsx');
}

public function exportUsersToExcel()
{
    return Excel::download(new UsersExport, 'users.xlsx');
}
public function exportGroupMembersToWord($kelompok)
{
    // Buat objek PhpWord
    $phpWord = new PhpWord();

    // Tambahkan bagian atau halaman baru
    $section = $phpWord->addSection();

    // Set title
    $section->addText("Group $kelompok Members", array('name' => 'Arial', 'size' => 14, 'bold' => true));

    // Ambil data anggota kelompok dengan role 'mahasiswa'
    $members = DB::table('users')
        ->where('kelompok', $kelompok)
        ->where('role', 'mahasiswa') // Menambahkan filter berdasarkan role
        ->get();

    // Tambahkan data anggota kelompok ke dalam tabel
    $table = $section->addTable();
    $table->addRow();
    $table->addCell(2000)->addText('Name');
    $table->addCell(2000)->addText('NIM');
    $table->addCell(2000)->addText('Email');

    foreach ($members as $member) {
        $table->addRow();
        $table->addCell(2000)->addText($member->name);
        $table->addCell(2000)->addText($member->nim);
        $table->addCell(2000)->addText($member->email);
    }

    // Output ke file Word
    $fileName = 'group_' . $kelompok . '_members.docx';
    $filePath = storage_path('app/public/' . $fileName);

    $phpWord->save($filePath);

    return response()->download($filePath);
}


// Export to Word for all users
public function exportUsersToWord()
{
    // Buat objek PhpWord
    $phpWord = new PhpWord();

    // Tambahkan bagian atau halaman baru
    $section = $phpWord->addSection();

    // Set title
    $section->addText("All Mahasiswa Users", array('name' => 'Arial', 'size' => 14, 'bold' => true));

    // Ambil data pengguna dengan role 'mahasiswa'
    $users = DB::table('users')
        ->where('role', 'mahasiswa') // Menambahkan filter berdasarkan role
        ->get();

    // Tambahkan data pengguna ke dalam tabel
    $table = $section->addTable();
    $table->addRow();
    $table->addCell(2000)->addText('Name');
    $table->addCell(2000)->addText('NIM');
    $table->addCell(2000)->addText('Email');

    foreach ($users as $user) {
        $table->addRow();
        $table->addCell(2000)->addText($user->name);
        $table->addCell(2000)->addText($user->nim);
        $table->addCell(2000)->addText($user->email);
    }

    // Output ke file Word
    $fileName = 'mahasiswa_users.docx';
    $filePath = storage_path('app/public/' . $fileName);

    $phpWord->save($filePath);

    return response()->download($filePath);
}










}
