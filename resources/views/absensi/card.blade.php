@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <div class="row">
        @forelse ($kegiatan as $item)
            <div class="col-md-4 mb-4 d-flex align-items-stretch">
                <div class="card shadow w-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Kegiatan: {{ $item->nama_kegiatan }}</h5>
                        {{-- <p class="card-text">Tanggal: {{ $item->tanggal }}</p> --}}
                        <a href="{{ route('absensi.scan', $item->id) }}" class="btn btn-primary">Scan QR Code</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">Tidak ada kegiatan yang tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
