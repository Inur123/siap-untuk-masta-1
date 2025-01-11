@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <h1>Generate Sertifikat By Name</h1>
{{--
    <form action="{{ url('/generate-certificate-admin') }}" method="POST">
        @csrf
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>

        <button type="submit">Generate Certificate</button>
    </form> --}}

    <form action="{{ url('/generate-certificate-admin') }}" method="POST" cla>
        @csrf
        <div class="form-group text-black">
            <label for="nama_kegiatan">Nama</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Generate Sertifikat</button>
    </form>

    @if(session('certificate_image'))
        <h2>Hasil Generated Sertifikat:</h2>
        <img src="{{ session('certificate_image') }}" alt="Generated Certificate" style="max-width: 50%; height: auto;">

        <br><br>

        <!-- Download Button -->
        <a href="{{ session('certificate_image') }}" download="{{ session('certificate_file') }}">
            <button type="submit" class="btn btn-primary mt-3">Download Sertifikat</button>
        </a>
    @endif
@endsection
