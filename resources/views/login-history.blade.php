@extends('layouts.app')

@section('sidebar')
@include('layouts.sidebar')
@endsection

<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <h1 class="mb-2">Login History</h1>
    <form action="{{ route('clear-login-history') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all login history?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mb-1">Clear Data</button>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="example">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Login Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loginHistory as $history)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $history->user->nim }}</td>
                        <td>{{ $history->user->name }}</td> <!-- Menampilkan nama pengguna -->
                        <td>{{ $history->user->role }}</td> <!-- Menampilkan nama pengguna -->
                        <td>{{ $history->ip_address }}</td>
                        <td>{{ $history->user_agent }}</td>
                        <td>{{ \Carbon\Carbon::parse($history->login_time)->format('d-m-Y H:i:s') }}</td> <!-- Format tanggal dan waktu -->
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
