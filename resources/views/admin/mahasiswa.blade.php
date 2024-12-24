@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1 class="mb-4">Data Mahasiswa</h1>
    <form action="{{ route('admin.mahasiswa.clear') }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mb-2" onclick="return confirm('Apakah anda yakin inggin menghapus seluruh data mahasiswa?');">Hapus Seluruh Data Mahasiswa </button>
    </form>
    <!-- Table Mahasiswa -->
    <div style="overflow-x: auto; white-space: nowrap; border: 1px solid #ddd; border-radius: 5px;">
        <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th style="padding: 8px; text-align: center;">No</th>
                    <th style="padding: 8px; text-align: center;">Email</th>
                    <th style="padding: 8px; text-align: center;">Name</th>
                    <th style="padding: 8px; text-align: center;">NIM</th>
                    <th style="padding: 8px; text-align: center;">Fakultas</th>
                    <th style="padding: 8px; text-align: center;">Prodi</th>
                    <th style="padding: 8px; text-align: center;">File</th>
                    <th style="padding: 8px; text-align: center;">Kelompok</th>
                    <th style="padding: 8px; text-align: center;">No Hp</th>
                    <th style="padding: 8px; text-align: center;">Alamat</th>
                    <th style="padding: 8px; text-align: center;">Jenis Kelamin</th>
                    <th style="padding: 8px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswa as $index => $user)
                <tr>
                    <td style="padding: 8px; text-align: center;">{{ $mahasiswa->firstItem() + $index }}</td>
                    <td style="padding: 8px; text-align: center;">{{ $user->email }}</td>
                    <td style="padding: 8px; text-align: center;">{{ $user->name }}</td>
                    <td style="padding: 8px; text-align: center;">{{ $user->nim }}</td>
                    <td style="padding: 8px; text-align: center;">{{ $user->fakultas }}</td>
                    <td style="padding: 8px; text-align: center;">{{ $user->prodi }}</td>
                    <td style="padding: 8px; text-align: center;">
                        @if ($user->file)
                            <a href="{{ asset('storage/' . $user->file) }}" target="_blank">View File</a>
                        @else
                            No File
                        @endif
                    </td>
                    <td style="padding: 8px; text-align: center;">{{ $user->kelompok }}</td>
                    <td style="padding: 8px; text-align: center;">{{ $user->nohp }}</td>
                    <td style="padding: 8px; text-align: center;">{{ $user->alamat }}</td>
                    <td style="padding: 8px; text-align: center;">{{ $user->jeniskelamin }}</td>
                    <td style="padding: 8px; text-align: center;">
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
    </div>
    <div class="pagination-wrapper" style="margin-top: 20px; text-align: end;">
        <style>
            /* Inactive page links */
            .pagination .page-link {
                background-color: white; /* White background for inactive links */
                border-color: #28a745; /* Green border for inactive links */
                color: #28a745; /* Green text for inactive links */
            }

            .pagination .page-link:hover {
                background-color: #218838; /* Dark green on hover */
                border-color: #1e7e34;
                color: white;  /* Dark green border on hover */
            }

            /* Active page link */
            .pagination .active .page-link {
                background-color: #28a745; /* Green background for active link */
                border-color: #1e7e34; /* Darker green border for active link */
                color: white; /* White text for active link */
            }
        </style>
        {{ $mahasiswa->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
