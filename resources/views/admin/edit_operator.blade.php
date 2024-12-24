@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1>Edit Pemandu</h1>

    <form action="{{ route('admin.update_operator', $operator->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Gunakan PUT untuk update -->

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $operator->name }}" required>
        </div>

        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" value="{{ $operator->nim }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $operator->email }}" required>
        </div>

        <div class="form-group">
            <label for="kelompok">Kelompok</label>
            <input type="text" class="form-control" id="kelompok" name="kelompok" value="{{ $operator->kelompok }}">
        </div>

        <div class="form-group">
            <label for="fakultas">Fakultas</label>
            <input type="text" class="form-control" id="fakultas" name="fakultas" value="{{ $operator->fakultas }}">
        </div>

        <div class="form-group">
            <label for="prodi">Prodi</label>
            <input type="text" class="form-control" id="prodi" name="prodi" value="{{ $operator->prodi }}">
        </div>

        <div class="form-group">
            <label for="file">Upload File</label>
            <input type="file" class="form-control-file" id="file" name="file">
            @if ($operator->file)
                <p class="mt-2">Current File: <a href="{{ asset('storage/' . $operator->file) }}" target="_blank">View File</a></p>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update Operator</button>
    </form>
</div>
@endsection
