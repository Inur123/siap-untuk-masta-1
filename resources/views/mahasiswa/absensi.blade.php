@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
@section('content')
<div class="container">
    <h2>Data Absensi</h2>

    @if($absensi->isEmpty())
        <p>Anda belum melakukan absensi untuk kegiatan apapun.</p>
    @else
        <!-- Progress bar for attendance -->
        <div class="progress mb-4">
            <div
                class="progress-bar"
                role="progressbar"
                style="width: {{ floor($percentage) }}%;"
                aria-valuenow="{{ floor($percentage) }}"
                aria-valuemin="0"
                aria-valuemax="100">
                {{ floor($percentage) }}%
            </div>
        </div>

        <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped table-hover" style="width: 100%; border-collapse: collapse;">
                <thead class="table-success">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kegiatan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal Absensi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kegiatan->nama_kegiatan }}</td>
                            <td>
                                <span class="badge
                                    {{ $item->status == 'hadir' ? 'bg-success' : ($item->status == 'tidak_hadir' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>{{ $item->created_at->format('d-m-Y | H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            $(document).ready(function () {
                new DataTable('#example');
            });
        </script>
    @endif
</div>
@endsection
