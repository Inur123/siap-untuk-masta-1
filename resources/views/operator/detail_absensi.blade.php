@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h2>Detail Absensi Kegiatan: {{ $kegiatan->nama_kegiatan }}</h2>

    <!-- Card Statistics -->
    <div class="row g-4 mb-4">
        <!-- Total Anggota Kelompok -->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100 ">
                <div class="app-card-body p-3 p-lg-4 ">
                    <h4 class="stats-type mb-1">Total Anggota Kelompok</h4>
                    <div class="stats-figure">{{ $kegiatan->absensi->count() }}</div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>

        <!-- Total yang Hadir -->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total yang Hadir</h4>
                    <div class="stats-figure">{{ $kegiatan->absensi->where('status', 'hadir')->count() }}</div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>

        <!-- Total yang Tidak Hadir -->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total yang Tidak Hadir</h4>
                    <div class="stats-figure">{{ $kegiatan->absensi->where('status', 'tidak hadir')->count() }}</div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>

        <!-- Total Izin -->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total Izin</h4>
                    <div class="stats-figure">{{ $kegiatan->absensi->where('status', 'izin')->count() }}</div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>
    </div>

    <h4>Absensi Mahasiswa Kelompok {{ $operator->kelompok }}</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Status Absensi</th>
                <th>Tanggal Absen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kegiatan->absensi as $absensi)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $absensi->user->name }}</td>
                    <td>{{ $absensi->user->nim }}</td>
                    <td>{{ ucfirst($absensi->status) }}</td>
                    <td>{{ $absensi->created_at->format('d-m-Y | H:i') }}</td> <!-- Tanggal absen -->
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('operator.absensi') }}" class="btn btn-secondary">Kembali ke Daftar Kegiatan</a>
</div>
@endsection
