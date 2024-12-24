<?php

namespace App\Http\Controllers\Operator;

use App\Models\Announcement;
use App\Http\Controllers\Controller;
use App\Models\User; // Import the User model

class OperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:operator']);
    }

    /**
     * Show the operator dashboard with student data.
     */
    public function dashboard()
    {
        // Get the authenticated operator
        $operator = auth()->user();

        // Retrieve announcements for the operator
        $announcements = Announcement::where('role', 'operator')
            ->where('is_active', true)  // Filter by active status
            ->latest()
            ->get();

        // Retrieve students who belong to the same group as the operator, using pagination
        $students = User::where('kelompok', $operator->kelompok)
                        ->where('role', 'mahasiswa') // Assuming 'mahasiswa' is the role for students
                        ->paginate(10); // Paginate to show 10 students per page

        // Return the view and pass the data
        return view('operator.dashboard', compact('students', 'operator', 'announcements'));
    }


}
