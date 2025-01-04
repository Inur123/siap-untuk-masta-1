<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiExport implements FromCollection, WithHeadings
{
    protected $absensi;

    // Constructor untuk menyertakan data absensi
    public function __construct($absensi)
    {
        $this->absensi = $absensi;
    }

    // Mengambil data yang akan diekspor
    public function collection()
    {
        return $this->absensi->map(function ($item) {
            // Tentukan tanggal absensi berdasarkan status
            $tanggalAbsensi = null;

            if ($item->status === 'hadir') {
                $tanggalAbsensi = $item->updated_at; // Tanggal update untuk status hadir
            } elseif ($item->status === 'izin') {
                $tanggalAbsensi = $item->updated_at; // Tanggal update untuk status izin
            }

            return [
                $item->user->name,       // Nama Mahasiswa
                $item->user->nim,        // NIM
                $item->status,           // Status (hadir, izin, tidak hadir)
                $tanggalAbsensi,         // Tanggal update absensi (untuk hadir/izin)
            ];
        });
    }

    // Menyediakan header untuk file Excel
    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM',
            'Status',
            'Tanggal Absensi',
        ];
    }
}

