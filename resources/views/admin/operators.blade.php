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
        <h1 class="mb-2">Data Pemandu</h1>
        <div class="mt-2">
            <a href="{{ route('admin.create_operator') }}"
            class="btn btn-success text-white border-success"
            style="--bs-btn-hover-color: #fff; --bs-btn-hover-bg: #198754; --bs-btn-hover-border-color: #198754;">
            Create New Pemandu
         </a>
        </div>
        <!-- Display Operators -->
        <table class="table table-bordered mt-2" id="example">
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
        <script>
            $(document).ready(function () {
                new DataTable('#example');
            });
        </script>
    </div>
@endsection
