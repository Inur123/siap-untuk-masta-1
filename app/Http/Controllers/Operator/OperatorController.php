<?php

namespace App\Http\Controllers\Operator;

use App\Models\Announcement;
use App\Http\Controllers\Controller;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport; // Import the User model
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

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

    // expor excel
    public function exportExcel()
    {
        // Ambil data operator yang sedang login
        $operator = auth()->user();

        // Ambil data mahasiswa yang memiliki kelompok yang sama dengan kelompok operator
        $students = User::where('role', 'mahasiswa') // Filter hanya mahasiswa
                        ->where('kelompok', $operator->kelompok) // Filter berdasarkan kelompok operator
                        ->get();

        // Ekspor data mahasiswa ke Excel
        return Excel::download(new StudentsExport($students), 'students_kelompok_' . $operator->kelompok . '.xlsx');
    }

    //export word
    public function exportWord()
    {
        // Get the authenticated operator
        $operator = auth()->user();

        // Get the students who belong to the same group as the operator
        $students = User::where('role', 'mahasiswa') // Only students
                        ->where('kelompok', $operator->kelompok) // Same group as the operator
                        ->get();

        // Create a new Word document
        $phpWord = new PhpWord();

        // Add a section to the Word document
        $section = $phpWord->addSection();

        // Add title
        $section->addTitle("Daftar Mahasiswa Kelompok: " . $operator->kelompok, 1);

        // Add student data in a table
        $section->addText("Anggota Mahasiswa:");
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(2000)->addText('Nama');
        $table->addCell(2000)->addText('NIM');

        foreach ($students as $student) {
            $table->addRow();
            $table->addCell(2000)->addText($student->name);
            $table->addCell(2000)->addText($student->nim);
        }

        // Save the Word document to a file
        $fileName = 'students_kelompok_' . $operator->kelompok . '.docx';
        $filePath = storage_path('app/public/' . $fileName);

        // Save to Word file
        $phpWord->save($filePath, 'Word2007');

        // Return the file as a download
        return response()->download($filePath)->deleteFileAfterSend(true);
    }


}
