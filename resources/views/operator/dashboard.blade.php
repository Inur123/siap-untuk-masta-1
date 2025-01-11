@extends('layouts.app')
@section('navbar')
@include('layouts.navbar')
@endsection
@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('content')
<div class="container">

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

    <div
      class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration"
      role="alert"
    >
      <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
          <h3 class="mb-3">Selamat Datang, {{ $operator->name }}!</h3>
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

    <h2>Data Mahasiswa Kelompok Kamu</h2>

    @if ($students->isEmpty())
        <p>Maaf belum ada mahasiswa yang masuk ke kelompok kamu</p>
    @else
        <p class="mb-0">Total Mahasiswa: {{ $students->count() }}</p> <!-- Display total number of students -->
        <p  class="mb-0">Total Laki Laki:  {{ $students->where('jeniskelamin', 'Laki-Laki')->count() }}</p>
        <p class="mb-0">Total Perempuan:  {{ $students->where('jeniskelamin', 'Perempuan')->count() }}</p> <!-- Display total number of students -->
        <!-- Display total number of students -->
        <div class="mb-1">
            <a href="{{ route('operator.exportExcel') }}" class="btn btn-success">Export Excel</a>
            <a href="{{ route('operator.exportWord') }}" class="btn btn-info">Export Word</a>
        </div>
        <div style="overflow-x: auto; white-space: nowrap; border: 1px solid #ddd; border-radius: 5px;">
            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="padding: 8px; text-align: center;">No</th>
                        <th style="padding: 8px; text-align: center;">QR Code</th>
                        <th style="padding: 8px; text-align: center;">Nama</th>
                        <th style="padding: 8px; text-align: center;">NIM</th>
                        <th style="padding: 8px; text-align: center;">Email</th>
                        <th style="padding: 8px; text-align: center;">Kelompok</th>
                        <th style="padding: 8px; text-align: center;">Fakultas</th>
                        <th style="padding: 8px; text-align: center;">Prodi</th>
                        <th style="padding: 8px; text-align: center;">No Hp</th>
                        <th style="padding: 8px; text-align: center;">Alamat</th>
                        <th style="padding: 8px; text-align: center;">Jenis Kelamin</th>
                        <th style="padding: 8px; text-align: center;">File</th>
                        <th style="padding: 8px; text-align: center;">Absensi Progress</th> <!-- New Column -->

                    </tr>
            </thead>
            <tbody>
                @foreach ($students as $index => $student)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $student->qr_code) }}" class="img-fluid rounded-start" alt="QR Code" style="max-width: 100px; max-height: 100px;">
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->nim }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->kelompok }}</td>
                        <td>{{ $student->fakultas }}</td>
                        <td>{{ $student->prodi }}</td>
                        <td>{{ $student->nohp }}</td>
                        <td>{{ $student->alamat }}</td>
                        <td>{{ $student->jeniskelamin }}</td>
                        <td>
                            @if ($student->file)
                                <a href="{{ asset('storage/' . $student->file) }}"target="_blank">
                                    <i class="fas fa-file-download"></i> Lihat File
                                </a>
                            @else
                                No file available
                            @endif
                        </td>
                        <td> {{ $student->absensi_progress }}%</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
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
        {{ $students->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
