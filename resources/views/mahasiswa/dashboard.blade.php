@extends('layouts.app')

@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <!-- Welcome Message -->

    <!-- Announcement Section -->
    <div
    class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration"
    role="alert"
  >
    <div class="inner">
      <div class="app-card-body p-3 p-lg-4">
        <h3 class="mb-3">Selamat Datang, {{ $user->name }}!</h3>
        <div class="row gx-5 gy-3">
          <div class="col-12 col-lg-9">
            <div>
              Selamat datang di MASTAMARU 2025. Silahkan gunakan fitur yang telah disediakan untuk mempermudah kegiatan anda.
            </div>
          </div>
        </div>
        <!--//row-->
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="alert"
          aria-label="Close"
        ></button>
      </div>
      <!--//app-card-body-->
    </div>
    <!--//inner-->
  </div>
    <!-- Tampilkan Pengumuman dari Database -->
    @if($announcements->isNotEmpty())
    <h3 class="mb-3">Pengumuman</h3>
    <div class="card mb-4">
        <div class="card-body">
            @foreach($announcements as $announcement)
                <div class="alert alert-primary">
                    <h5>{{ $announcement->title }}</h5>
                    <p>{{ $announcement->content }}</p>
                </div>
            @endforeach
        </div>
    </div>
@else
    @endif

    <!-- Section: Pemandu -->
    <h2 class="mb-3">Pemandu</h2>
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex flex-column mb-0">
                <!-- Nama and Nomor HP in the same row -->
                <div class="row mb-3">
                    <div class="col-12 col-md-6 d-flex align-items-center">
                        <strong>Nama:</strong>
                        <span class="ml-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            @if ($operator)
                                {{ $operator->name }} <!-- Display operator's name -->
                            @else
                                Pemandu belum tersedia
                            @endif
                        </span>
                    </div>
                    <div class="col-12 col-md-6 d-flex align-items-center">
                        <strong>Nomor HP:</strong>
                        <span class="ml-2">
                            @if ($operator)
                                {{ $operator->nohp }} <!-- Display operator's phone number -->
                            @else
                                Nomor HP pemandu belum tersedia
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Fakultas and Prodi in the same row -->
                <div class="row">
                    <div class="col-12 col-md-6 d-flex align-items-center">
                        <strong>Fakultas:</strong>
                        <span class="ml-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            @if ($operator)
                                {{ $operator->fakultas }} <!-- Display operator's faculty -->
                            @else
                                Pemandu belum tersedia
                            @endif
                        </span>
                    </div>
                    <div class="col-12 col-md-6 d-flex align-items-center">
                        <strong>Prodi:</strong>
                        <span class="ml-2">
                            @if ($operator)
                                {{ $operator->prodi }} <!-- Display operator's program -->
                            @else
                                Prodi pemandu belum tersedia
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Section: Your Details -->
    <h2 class="mb-3">Your Details</h2>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4 d-flex justify-content-center align-items-center"  style="padding-left: 20px;">
                <img src="{{ asset('storage/' . $user->qr_code) }}" class="img-fluid rounded-start" alt="QR Code">
            </div>
          <div class="col-md-8">
            <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                <li class="list-group-item"><strong>No Hp:</strong> {{ $user->nohp }}</li>
                <li class="list-group-item"><strong>Alamat:</strong> {{ $user->alamat }}</li>
                <li class="list-group-item"><strong>Jenis Kelamin:</strong> {{ $user->jeniskelamin }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>NIM:</strong> {{ $user->nim }}</li>
                <li class="list-group-item"><strong>Fakultas:</strong> {{ $user->fakultas }}</li>
                <li class="list-group-item"><strong>Prodi:</strong> {{ $user->prodi }}</li>
                <li class="list-group-item"><strong>Kelompok:</strong> {{ $user->kelompok }}</li>
                <li class="list-group-item">
                    <strong>Uploaded File:</strong>
                    @if($user->file)
                        @php
                            $extension = pathinfo($user->file, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $user->file) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $user->file) }}" alt="Current file" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                </a>
                            </div>
                        @elseif($extension === 'pdf')
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $user->file) }}" target="_blank">
                                    <embed src="{{ asset('storage/' . $user->file) }}" type="application/pdf" width="200" height="200" class="border rounded">
                                </a>
                            </div>
                        @else
                            <p>Current file type: {{ $extension }}</p>
                            <p class="text-muted">Preview not available for this file type.</p>
                        @endif
                    @else
                        <p>No file uploaded.</p>
                    @endif
                </li>
            </ul>

            </div>
          </div>
        </div>
    </div>

    <!-- Edit Data Button -->
    <div class="mt-4">
        <a href="{{ route('mahasiswa.edit', $user->id) }}" class="btn btn-warning">Edit Data</a>
        <a href="{{ $qrCodeUrl }}"  download="{{ $user->qr_code }}" class="btn btn-success">Download QRCode</a>
    </div>
</div>
@endsection
