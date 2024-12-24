@extends('layouts.app')

@section('sidebar')
@include('layouts.sidebar')
@endsection
@section('content')
    <div class="container">
        <h1 class="mb-2">Data Pemandu</h1>
        <div class="mt-2">
            <a href="{{ route('admin.create_operator') }}"
            class="btn btn-success text-white border-success"
            style="--bs-btn-hover-color: #fff; --bs-btn-hover-bg: #198754; --bs-btn-hover-border-color: #198754;">
            Create New Pemandu
         </a>
        </div>
        <!-- Display Operators -->
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Kelompok</th>
                    <th>Fakultas</th>
                    <th>Prodi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($operators as $index=> $operator)
                    <tr>
                        <td>{{ $operators->firstItem() + $index }}</td>
                        <td>{{ $operator->name }}</td>
                        <td>{{ $operator->email }}</td>
                        <td>{{ $operator->kelompok }}</td>
                        <td>{{ $operator->fakultas }}</td>
                        <td>{{ $operator->prodi }}</td>
                        <td>
                            <!-- Add action buttons for edit, delete, etc. -->
                            <a href="{{ route('admin.edit_operator', $operator->id) }}" class="btn btn-outline-success"><i class="fas fa-edit"></i>Edit</a>
                            <!-- Example of delete button or other actions -->
                            <form action="{{ route('admin.operator.destroy', $operator->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Apakah kamu yakin menghapus pemandu?');" title="Delete User">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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

            {{ $operators->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection
