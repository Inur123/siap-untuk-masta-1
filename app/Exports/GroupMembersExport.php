<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GroupMembersExport implements FromCollection, WithHeadings
{
    protected $kelompok;

    // Pass the kelompok parameter to the constructor
    public function __construct($kelompok)
    {
        $this->kelompok = $kelompok;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Get all group members based on the kelompok (group) value
        return User::where('kelompok', $this->kelompok)
                    ->where('role', 'mahasiswa')
                    ->get();
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
