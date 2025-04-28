@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h2>Detail Absensi Kegiatan: {{ $kegiatan->nama_kegiatan }}</h2>

    <!-- Card Statistics -->
    <div class="row g-4 mb-4">
        <!-- Total Anggota Kelompok -->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100 ">
                <div class="app-card-body p-3 p-lg-4 ">
                    <h4 class="stats-type mb-1">Total Anggota Kelompok</h4>
                    <div class="stats-figure">{{ $kegiatan->absensi->count() }}</div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>

        <!-- Total yang Hadir -->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total yang Hadir</h4>
                    <div class="stats-figure">
                        {{ $kegiatan->absensi->where('status', 'hadir')->count() }}
                    </div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>

        <!-- Total yang Tidak Hadir -->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total yang Tidak Hadir</h4>
                    <div class="stats-figure">
                        {{ $kegiatan->absensi->where('status', 'tidak_hadir')->count() }}
                    </div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>

        <!-- Total Izin -->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total Izin</h4>
                    <div class="stats-figure">
                        {{ $kegiatan->absensi->where('status', 'izin')->count() }}
                    </div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>
    </div>

    <h4>Absensi Mahasiswa Kelompok {{ $operator->kelompok }}</h4>
    <div style="max-height: 500px; overflow: auto; border: 1px solid #ddd; border-radius: 5px;">
        <table class="table table-bordered" style="width: 100%; border-collapse: collapse; min-width: 1200px;">
            <thead style="position: sticky; top: 0; background-color: #f8f9fa; z-index: 1;">
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Status Absensi</th>
                    <th>Tanggal Absen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kegiatan->absensi as $absensi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $absensi->user->name }}</td>
                        <td>{{ $absensi->user->nim }}</td>
                        <td>
                            <div class="d-flex">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio"
                                        name="status[{{ $absensi->user->id }}]" value="hadir"
                                        {{ $absensi->status == 'hadir' ? 'checked' : '' }}
                                        data-user-id="{{ $absensi->user->id }}" data-status="hadir">
                                    <label class="form-check-label">Hadir</label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio"
                                        name="status[{{ $absensi->user->id }}]" value="tidak_hadir"
                                        {{ $absensi->status == 'tidak_hadir' ? 'checked' : '' }}
                                        data-user-id="{{ $absensi->user->id }}" data-status="tidak_hadir">
                                    <label class="form-check-label">Tidak Hadir</label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio"
                                        name="status[{{ $absensi->user->id }}]" value="izin"
                                        {{ $absensi->status == 'izin' ? 'checked' : '' }}
                                        data-user-id="{{ $absensi->user->id }}" data-status="izin">
                                    <label class="form-check-label">Izin</label>
                                </div>
                            </div>
                        </td>
                        <td>{{ $absensi->created_at->format('d-m-Y | H:i') }}</td> <!-- Tanggal absen -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('operator.absensi') }}" class="btn btn-secondary mt-2">Kembali ke Daftar Kegiatan</a>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('input[type="radio"]').on('change', function() {
            var status = $(this).val();
            var userId = $(this).data('user-id');
            var kegiatanId = '{{ $kegiatan->id }}';

            $.ajax({
                url: `/absensi/${kegiatanId}/${userId}/update`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        alert('Absensi berhasil diperbarui');
                        location.reload();
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memperbarui absensi');
                }
            });
        });
    });
</script>
@endsection
