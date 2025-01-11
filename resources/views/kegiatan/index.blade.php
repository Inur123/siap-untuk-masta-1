@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
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
    <table id="example" class="table table-bordered" style="width: 100%; border-collapse: collapse;">
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
                            <a href="{{ route('kegiatan.edit', $kegiatan->id) }}">
                                <button class="btn btn-warning">Edit</button>
                            </a>
                            <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <script>
            $(document).ready(function () {
                new DataTable('#example');
            });
        </script>
    @endif
</div>
@endsection
