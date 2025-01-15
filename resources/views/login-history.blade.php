@extends('layouts.app')

@section('sidebar')
@include('layouts.sidebar')
@endsection

<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
@section('content')

    <h1 class="mb-4">Login History</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="example">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>User Name</th>
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
