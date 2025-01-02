@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1 class="my-4">Daftar Kegiatan</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Tambah Kegiatan -->
    <a href="{{ route('kegiatan.create') }}" class="btn btn-primary mb-4">Tambah Kegiatan</a>

    <!-- Tabel Daftar Kegiatan -->
    @if($kegiatans->isEmpty())
        <p>Tidak ada kegiatan yang tersedia.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatans as $kegiatan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kegiatan->nama_kegiatan }}</td>
                        <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }}</td>
                        <td>
                            <!-- Link to QR code scan -->
                            <a href="{{ route('absensi.scan', $kegiatan->id) }}">
                                <button class="btn btn-info">Absen</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
