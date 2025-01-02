@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h2>Daftar Kelompok Absensi untuk {{ $kegiatan->nama_kegiatan }}</h2>

    <!-- Bootstrap grid to display groups in 3 columns -->
    <div class="row">
        @foreach($kelompoks as $kelompok)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Kelompok {{ $kelompok->kelompok }}</h3>
                    </div>
                    <div class="card-body">
                        <!-- Get all users in the group with the role 'mahasiswa' -->
                        @php
                            $groupUsers = $users->where('kelompok', $kelompok->kelompok)->where('role', 'mahasiswa');
                            $totalUsers = $groupUsers->count();

                            // Inisialisasi variabel
                            $hadirCount = 0;
                            $izinCount = 0;
                            $tidakHadirCount = 0;

                            // Get users who attended (status = 'hadir')
                            $hadir = $groupUsers->filter(function($user) use ($kegiatan) {
                                return $kegiatan->absensi->contains('user_id', $user->id) &&
                                       $kegiatan->absensi->where('user_id', $user->id)->first()->status == 'hadir';
                            });
                            $hadirCount = $hadir->count();

                            // Get users who are 'izin'
                            $izin = $groupUsers->filter(function($user) use ($kegiatan) {
                                return $kegiatan->absensi->contains('user_id', $user->id) &&
                                       $kegiatan->absensi->where('user_id', $user->id)->first()->status == 'izin';
                            });
                            $izinCount = $izin->count();

                            // Get users who are 'tidak hadir'
                            $tidakHadir = $groupUsers->diff($hadir)->diff($izin);
                            $tidakHadirCount = $tidakHadir->count();
                        @endphp

                        <!-- Display total users, hadir, tidak hadir, and izin counts -->
                        <p><strong>Total Anggota Kelompok:</strong> {{ $totalUsers }} orang</p>
                        <p><strong>Hadir:</strong> {{ $hadirCount }} orang</p>
                        <p><strong>Tidak Hadir:</strong> {{ $tidakHadirCount }} orang</p>
                        <p><strong>Izin:</strong> {{ $izinCount }} orang</p>

                        <!-- Button to view details of the specific group -->
                        <a href="{{ route('absensi.group.detail', ['kegiatanId' => $kegiatan->id, 'kelompokId' => $kelompok->kelompok]) }}" class="btn btn-primary">Detail Absensi Kelompok {{ $kelompok->kelompok }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
