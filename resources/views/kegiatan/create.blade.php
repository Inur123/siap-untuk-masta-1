@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1 class="my-4">Tambah Kegiatan</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('kegiatan.store') }}" method="POST">
        @csrf
        <div class="form-group text-black">
            <label for="nama_kegiatan">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan Kegiatan</button>
        <a href="{{ url('kegiatan') }}" class="btn btn-danger mt-3">Kembali</a>
    </form>
</div>
@endsection
