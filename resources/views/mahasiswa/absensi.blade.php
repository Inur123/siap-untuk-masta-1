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
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kegiatan</th>
                    <th>Status</th>
                    <th>Tanggal Absensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensi as $item)
                    <tr>
                        <td>{{ $item->kegiatan->nama_kegiatan }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->created_at->format('d-m-Y | H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
