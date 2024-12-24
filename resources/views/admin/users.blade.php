
@extends('layouts.app')
@section('navbar')
@include('layouts.navbar')
@endsection
@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1 class="mb-4 text-start">Data Admin</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif




    <div class="card shadow">
        <div class="card-body">
            {{-- <div class="mb-3">
                <a href="{{ route('admin.assign.groups') }}" class="btn btn-primary mb-3">
                    Assign Users to Groups
                </a>
                <a href="{{ route('admin.clearGroups') }}" class="btn btn-danger"
                   onclick="return confirm('Are you sure you want to clear all group data?');">
                   Clear Group Data
                </a>
                <a href="{{ route('admin.users') }}" class="btn btn-success">Add New User</a>
            </div> --}}

            <!-- Mahasiswa Users Table -->
            {{-- <h3>Mahasiswa Users</h3>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>NIM</th>
                        <th>Fakultas</th>
                        <th>Prodi</th>
                        <th>File</th>
                        <th>Kelompok</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswa as $user)
                        <tr>
                            <td>{{ ($mahasiswa->currentPage() - 1) * $mahasiswa->perPage() + $loop->iteration }}</td>
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
                            <td>
                                <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-primary btn-sm" title="Edit User">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete User">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $mahasiswa->links('pagination::bootstrap-4') }}
            </div> --}}

            <!-- Admin Users Table -->

            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>NIM</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admin as $user)
                        <tr>
                            <td>{{ ($admin->currentPage() - 1) * $admin->perPage() + $loop->iteration }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nim }}</td>
                            <td>
                                <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-outline-primary" title="Edit User">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"  class="btn btn-outline-danger" onclick="return confirm('Apakah anda inggin menghapus admin?');" title="Delete User">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $admin->links('pagination::bootstrap-4') }}
            </div>

            <!-- Operator Users Table -->
            {{-- <h3>Operator Users</h3>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>NIM</th>
                        <th>Kelompok</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($operator as $user)
                        <tr>
                            <td>{{ ($operator->currentPage() - 1) * $operator->perPage() + $loop->iteration }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nim }}</td>
                            <td>{{ $user->kelompok }}</td>
                            <td>
                                <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-primary btn-sm" title="Edit User">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete User">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $operator->links('pagination::bootstrap-4') }}
            </div> --}}
        </div>
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
        {{ $admin->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

@push('scripts')
<!-- Include Font Awesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush
