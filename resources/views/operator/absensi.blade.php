@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h2>Daftar Kegiatan dan Absensi Kelompok {{ $operator->kelompok }}</h2>

    <!-- Grid to display activities in cards -->
    <div class="row">
        @foreach($kegiatans as $kegiatan)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title ">{{ $kegiatan->nama_kegiatan }}</h5>
                    </div>
                    <div class="card-body">
                        <!-- Absensi summary -->
                        <p><strong>Hadir:</strong> {{ $kegiatan->absensi->where('status', 'hadir')->count() }} orang</p>
                        <p><strong>Tidak Hadir:</strong> {{ $kegiatan->absensi->where('status', 'tidak_hadir')->count() }} orang</p>
                        <p><strong>Izin:</strong> {{ $kegiatan->absensi->where('status', 'izin')->count() }} orang</p>

                        <!-- Button for detailed attendance -->
                        <a href="{{ route('operator.absensi.detail', ['kegiatanId' => $kegiatan->id]) }}" class="btn btn-outline-primary btn-sm">Detail Absensi</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
