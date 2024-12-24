@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>


@section('content')
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="container">
    <h1 class="mb-4">Data Mahasiswa</h1>
    <form action="{{ route('admin.mahasiswa.clear') }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mb-2" onclick="return confirm('Apakah anda yakin ingin menghapus seluruh data mahasiswa?');">Hapus Seluruh Data Mahasiswa</button>
        <a href="{{ route('admin.exportUsers') }}" class="btn btn-success mb-2">Export Users to Excel</a>
        <a href="{{ route('admin.exportUsersToWord') }}" class="btn btn-info mb-2">Export Users to Word</a>
    </form>

    <!-- Tabel Mahasiswa -->
    <div style="overflow-x: auto; white-space: nowrap; border: 1px solid #ddd; border-radius: 5px;">
        <table id="example" class="table table-bordered" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th>No</th>
                    <th>QR Code</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>NIM</th>
                    <th>Fakultas</th>
                    <th>Prodi</th>
                    <th>File</th>
                    <th>Kelompok</th>
                    <th>No Hp</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswa as $index => $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $user->qr_code) }}" class="img-fluid rounded-start" alt="QR Code" style="max-width: 100px; max-height: 100px;">
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->nim }}</td>
                    <td>{{ $user->fakultas }}</td>
                    <td>{{ $user->prodi }}</td>
                    <td>
                        @if ($user->file)
                            <a href="{{ asset('storage/' . $user->file) }}" target="_blank">View File</a>
                        @else
                            No File
                        @endif
                    </td>
                    <td>{{ $user->kelompok }}</td>
                    <td>{{ $user->nohp }}</td>
                    <td>{{ $user->alamat }}</td>
                    <td>{{ $user->jeniskelamin }}</td>
                    <td>
                        <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-outline-success" title="Edit User" style="margin-right: 5px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Apakah kamu yakin menghapus mahasiswa?');" title="Delete User">
                                <i class="fas fa-trash"></i> Delete
                            </button>
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
    </div>
</div>


@endsection

