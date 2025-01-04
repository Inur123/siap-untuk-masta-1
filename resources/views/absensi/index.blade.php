@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h2>Daftar Kegiatan dan Absensi</h2>

    <!-- Dropdown untuk memilih kegiatan dan kelompok (admin) -->
    @if(auth()->user()->role === 'admin')
    <form action="{{ route('export.absensi') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <label for="kegiatan">Pilih Kegiatan</label>
                <select name="kegiatan_id" id="kegiatan" class="form-control">
                    @foreach($kegiatans as $kegiatan)
                        <option value="{{ $kegiatan->id }}">{{ $kegiatan->nama_kegiatan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="kelompok">Pilih Kelompok</label>
                <select name="kelompok" id="kelompok" class="form-control">
                    <option value="all">Semua Kelompok</option>
                    @foreach(range(1, 14) as $kelompok)
                        <option value="{{ $kelompok }}">Kelompok {{ $kelompok }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success mt-3">Download Excel</button>
    </form>
@endif


    <!-- Bootstrap grid to display events in 3 columns -->
    <div class="row">
        @foreach($kegiatans as $kegiatan)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">{{ $kegiatan->nama_kegiatan }}</h3>
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
                        <a href="{{ route('absensi.groups', ['kegiatanId' => $kegiatan->id]) }}" class="btn btn-outline-primary btn-sm">Detail Semua Kelompok Absensi</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
