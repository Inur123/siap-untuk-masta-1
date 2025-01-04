<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function showPreview()
    {
        $user = auth()->user();

        // Cek apakah sertifikat sudah ada
        $certificate = Certificate::where('user_id', $user->id)->first();

        if ($certificate && $certificate->is_generated) {
            return view('sertifikat.preview', compact('certificate'));
        }

        return view('sertifikat.preview', ['certificate' => null]);
    }

    public function generate(Request $request)
    {
        // Ambil data pengguna yang sedang login
        $user = auth()->user();
        $name = $user->name;
        $nim = $user->nim;  // Asumsi nim tersimpan dalam database

        // Ubah nama menjadi format yang diinginkan
        $name = ucwords(strtolower($name));

        // Membuat nama file dengan format NIM_Nama
        $fileName = $nim . '_' . strtolower(str_replace(' ', '_', $name)) . '.png';

        // Path ke template sertifikat
        $templatePath = public_path('template/sertifikat-template.png');

        // Cek apakah file template ada
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template file not found.'], 404);
        }

        // Membuka gambar template
        $img = imagecreatefrompng($templatePath);

        // Tentukan warna teks
        $color = imagecolorallocate($img, 165, 42, 42);  // RGB untuk #a52a2a

        // Tentukan font dan ukuran
        $fontPath = public_path('fonts/Roboto-Medium.ttf');  // Pastikan path font benar
        $fontSize = 50;  // Ukuran font

        // Hitung posisi teks agar berada di tengah
        $textBoundingBox = imagettfbbox($fontSize, 0, $fontPath, $name);
        $textWidth = $textBoundingBox[2] - $textBoundingBox[0];  // Lebar teks
        $textHeight = $textBoundingBox[1] - $textBoundingBox[7];  // Tinggi teks

        // Hitung posisi teks agar berada di tengah secara horizontal
        $x = (imagesx($img) - $textWidth) / 2;
        $y = (imagesy($img) - $textHeight) / 2 - 37.8;  // Menaikkan teks sebesar 1 cm

        // Menambahkan teks ke gambar
        imagettftext($img, $fontSize, 0, $x, $y, $color, $fontPath, $name);

        // Menyimpan gambar ke file sementara di server
        $outputPath = 'sertifikat/' . $fileName;

        // Pastikan folder 'sertifikat' ada
        if (!is_dir(public_path('storage/sertifikat'))) {
            mkdir(public_path('storage/sertifikat'), 0777, true);
        }

        // Menyimpan gambar ke folder sertifikat
        $path = public_path('storage/' . $outputPath);
        imagepng($img, $path);

        // Hapus gambar dari memori
        imagedestroy($img);

        // Simpan informasi sertifikat ke database
        $certificate = Certificate::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'certificate_image' => $outputPath,  // Path relatif ke storage
                'is_generated' => true
            ]
        );

        // Kembalikan response JSON dengan path gambar yang baru dihasilkan
        return response()->json(['image' => asset('storage/' . $outputPath)]);
    }

    public function download($id)
    {
        $certificate = Certificate::findOrFail($id);

        // Cek apakah sertifikat sudah digenerate
        if (!$certificate->is_generated) {
            return response()->json(['message' => 'Certificate not generated yet'], 400);
        }

        // Ambil NIM dan nama pengguna
        $user = $certificate->user;
        $nim = $user->nim;
        $name = $user->name;
        $name = strtolower(str_replace(' ', '_', $name));  // Mengubah spasi menjadi underscore

        // Membuat nama file untuk download
        $fileName = $nim . '_' . $name . '.png';

        // Download sertifikat dengan nama yang telah ditentukan
        return response()->download(public_path('storage/' . $certificate->certificate_image), $fileName);
    }
}
