@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-2">Detail Kelompok {{ $groupDetail->kelompok }}</h1>

        <p><strong>Fakultas:</strong> {{ $groupDetail->fakultas }}</p>

        <!-- Menampilkan Nama Pemandu dan Nomor HP -->
        <p><strong>Nama Pemandu:</strong> {{ $pemanduName }}</p>
        <p><strong>Nomor HP Pemandu:</strong> {{ $pemanduPhone }}</p>

        <h3 class="text-lg font-semibold mt-2">Daftar Anggota:</h3>
        <p><strong>Total Anggota:</strong> {{ count($groupMembers) }}</p>
        <p><strong>Laki-laki:</strong> {{ $groupMembers->where('jeniskelamin', 'Laki-Laki')->count() }}</p>
        <p><strong>Perempuan:</strong> {{ $groupMembers->where('jeniskelamin', 'Perempuan')->count() }}</p>
        <div style="overflow-x: auto; white-space: nowrap; border: 1px solid #ddd; border-radius: 5px;">
            <table class="table-auto w-full mt-2 table table-bordered" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th class="px-4 py-2 border" style="padding: 8px; text-align: center;">No</th>
                        <th class="px-4 py-2 border" style="padding: 8px; text-align: center;">Email</th>
                        <th class="px-4 py-2 border" style="padding: 8px; text-align: center;">Name</th>
                        <th class="px-4 py-2 border" style="padding: 8px; text-align: center;">NIM</th>
                        <th class="px-4 py-2 border" style="padding: 8px; text-align: center;">Fakultas</th>
                        <th class="px-4 py-2 border" style="padding: 8px; text-align: center;">Prodi</th>
                        <th class="px-4 py-2 border" style="padding: 8px; text-align: center;">File</th>
                        <th class="px-4 py-2 border" style="padding: 8px; text-align: center;">Kelompok</th>
                        <th class="px-4 py-2 border" style="padding: 8px; text-align: center;">No Hp</th>
                        <th class="px-4 py-2 border" style="padding: 8px; text-align: center;">Alamat</th>
                        <th class="px-4 py-2 border" style="padding: 8px; text-align: center;">Jenis Kelamin</th>
                        <th class="px-4 py-2 border" style="padding: 8px; text-align: center;">Progres Absensi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupMembers as $index => $member)
                    <tr>
                        <td style="padding: 8px; text-align: center;">{{ $index + 1 }}</td>
                        <td style="padding: 8px; text-align: center;">{{ $member->email }}</td>
                        <td style="padding: 8px; text-align: center;">{{ $member->name }}</td>
                        <td style="padding: 8px; text-align: center;">{{ $member->nim }}</td>
                        <td style="padding: 8px; text-align: center;">{{ $member->fakultas }}</td>
                        <td style="padding: 8px; text-align: center;">{{ $member->prodi }}</td>
                        <td style="padding: 8px; text-align: center;">
                            @if ($member->file)
                                <a href="{{ asset('storage/' . $member->file) }}" target="_blank">View File</a>
                            @else
                                No File
                            @endif
                        </td>
                        <td style="padding: 8px; text-align: center;">{{ $member->kelompok }}</td>
                        <td style="padding: 8px; text-align: center;">{{ $member->nohp }}</td>
                        <td style="padding: 8px; text-align: center;">{{ $member->alamat }}</td>
                        <td style="padding: 8px; text-align: center;">{{ $member->jeniskelamin }}</td>
                        <td style="padding: 8px; text-align: center;">{{ $member->absensi_progress }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ route('admin.groups') }}" class="text-blue-500 hover:underline mt-4 block">Kembali ke Daftar Kelompok</a>
    </div>
@endsection
