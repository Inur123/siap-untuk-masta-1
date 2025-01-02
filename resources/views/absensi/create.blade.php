@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1 class="my-4">Absen untuk Kegiatan: {{ $kegiatan->nama_kegiatan }}</h1>

    <!-- Form untuk memilih status absen -->
    <form action="{{ route('absensi.store', $kegiatan->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="status">Status Kehadiran</label>
            <select name="status" id="status" class="form-control">
                <option value="hadir">Hadir</option>
                <option value="tidak hadir">Tidak Hadir</option>
                <option value="izin">Izin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Absen</button>
    </form>
</div>
@endsection
