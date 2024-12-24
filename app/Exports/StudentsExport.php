<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function collection()
    {
        return $this->students->map(function ($student) {
            return [
                'name' => $student->name,
                'nim' => $student->nim,
                'email' => $student->email,
                'kelompok' => $student->kelompok,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'NIM',
            'Email',
            'Kelompok',
        ];
    }
}
