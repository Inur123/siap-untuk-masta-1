@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

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

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kegiatan</th>
                    <th>Status</th>
                    <th>Tanggal Absensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kegiatan->nama_kegiatan }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>{{ $item->created_at->format('d-m-Y | H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
