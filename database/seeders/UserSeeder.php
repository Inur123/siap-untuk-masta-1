<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder untuk role 'admin' - 1 user
        $adminNim = '1234567890';
        $adminQrCodePath = 'storage/qrcodes/' . $adminNim . '.png';
        QrCode::format('png')->size(300)->generate($adminNim, public_path($adminQrCodePath));

        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpassword'), // Ganti dengan password yang diinginkan
            'role' => 'admin',
            'nim' => $adminNim,
            'fakultas' => 'Fakultas Teknik',
            'prodi' => 'Teknik Informatika',
            'file' => 'path/to/file',
            'kelompok' => '1',
            'nohp' => '081234567890',
            'alamat' => 'Jl. Contoh Alamat, Kota Contoh',
            'jeniskelamin' => 'Laki-Laki',
            'qr_code' => $adminQrCodePath,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seeder untuk role 'operator' - 5 user
        for ($i = 1; $i <= 5; $i++) {
            $nim = '098765432' . $i;
            $qrCodePath = 'storage/qrcodes/' . $nim . '.png';
            QrCode::format('png')->size(300)->generate($nim, public_path($qrCodePath));

            DB::table('users')->insert([
                'name' => 'Operator User ' . $i,
                'email' => 'operator' . $i . '@example.com',
                'password' => Hash::make('operatorpassword'),
                'role' => 'operator',
                'nim' => $nim,
                'fakultas' => 'Fakultas Hukum',
                'prodi' => 'Ilmu Hukum',
                'file' => 'path/to/file',
                'kelompok' => '2',
                'nohp' => '08234567890' . $i,
                'alamat' => 'Jl. Operator Alamat, Kota Operator',
                'jeniskelamin' => 'Perempuan',
                'qr_code' => $qrCodePath,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seeder untuk role 'mahasiswa' - 10 user
        for ($i = 1; $i <= 10; $i++) {
            $nim = '2020' . str_pad($i, 4, '0', STR_PAD_LEFT);
            $qrCodePath = 'storage/qrcodes/' . $nim . '.png';
            QrCode::format('png')->size(300)->generate($nim, public_path($qrCodePath));

            DB::table('users')->insert([
                'name' => 'Mahasiswa User ' . $i,
                'email' => 'mahasiswa' . $i . '@example.com',
                'password' => Hash::make('mahasiswapassword'),
                'role' => 'mahasiswa',
                'nim' => $nim,
                'fakultas' => 'Fakultas Ekonomi',
                'prodi' => 'Manajemen',
                'file' => 'path/to/file',
                'kelompok' => '3',
                'nohp' => '0834567890' . $i,
                'alamat' => 'Jl. Mahasiswa Alamat, Kota Mahasiswa',
                'jeniskelamin' => 'Laki-Laki',
                'qr_code' => $qrCodePath,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
