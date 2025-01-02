@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h2>Daftar Kegiatan dan Absensi</h2>

    <!-- Bootstrap grid to display events in 3 columns -->
    <div class="row">
        @foreach($kegiatans as $kegiatan)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $kegiatan->nama_kegiatan }}</h3>
                    </div>
                    <div class="card-body">
                        <h5>Absensi:</h5>

                        <!-- Displaying total attendees for the event (status = 'hadir') -->
                        <h6>Hadir:</h6>
                        <p>{{ $kegiatan->absensi()->where('status', 'hadir')->count() }} orang</p>

                        <!-- Displaying total absentees for the event (status = 'tidak hadir') -->
                        <h6>Tidak Hadir:</h6>
                        <p>{{ $kegiatan->absensi()->where('status', 'tidak_hadir')->count() }} orang</p>

                        <!-- Displaying total number of users with 'izin' status -->
                        <h6>Izin:</h6>
                        <p>{{ $kegiatan->absensi()->where('status', 'izin')->count() }} orang</p>

                        <!-- Button to view detailed attendance for this event -->
                        <a href="{{ route('absensi.groups', ['kegiatanId' => $kegiatan->id]) }}" class="btn btn-primary">Detail Semua Kelompok Absensi</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
