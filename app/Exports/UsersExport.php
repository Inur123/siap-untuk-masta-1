<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::all(); // Export all users, you can modify this as needed
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID', 'Name', 'Email', 'Role', 'NIM', 'Fakultas', 'Prodi', 'Kelompok', 'Created At', 'Updated At'
        ];
    }
}
