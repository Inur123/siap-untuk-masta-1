@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h2>Detail Absensi Kelompok {{ $kelompokId }}</h2>

    <!-- Card Statistik -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total Anggota Kelompok</h4>
                    <div class="stats-figure">{{ $users->count() }}</div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total yang Hadir</h4>
                    <div class="stats-figure">{{ count($attendedUserIds ?? []) }}</div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total yang Tidak Hadir</h4>
                    <div class="stats-figure">{{ $users->count() - count($attendedUserIds ?? []) - count($izin ?? []) }}</div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total Izin</h4>
                    <div class="stats-figure">{{ count($izin ?? []) }}</div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>
    </div>

    <form>
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nim</th>
                    <th>Absensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->nim }}</td>
                        <td>
                            @php
                                $attendance = $user->absensi->firstWhere('kegiatan_id', $kegiatan->id); // Temukan data absensi berdasarkan kegiatan_id
                            @endphp

                            <!-- Flexbox untuk menampilkan radio button secara horizontal -->
                            <div class="d-flex">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="status[{{ $user->id }}]" value="hadir"
                                           {{ $attendance && $attendance->status == 'hadir' ? 'checked' : '' }}
                                           data-user-id="{{ $user->id }}" data-status="hadir">
                                    <label class="form-check-label">Hadir</label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="status[{{ $user->id }}]" value="tidak_hadir"
                                           {{ $attendance && $attendance->status == 'tidak_hadir' ? 'checked' : '' }}
                                           data-user-id="{{ $user->id }}" data-status="tidak_hadir">
                                    <label class="form-check-label">Tidak Hadir</label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="status[{{ $user->id }}]" value="izin"
                                           {{ $attendance && $attendance->status == 'izin' ? 'checked' : '' }}
                                           data-user-id="{{ $user->id }}" data-status="izin">
                                    <label class="form-check-label">Izin</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
</div>

<!-- Menyertakan jQuery untuk AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Event listener saat radio button diubah
        $('input[type="radio"]').on('change', function() {
            var status = $(this).val(); // Mendapatkan nilai status yang dipilih
            var userId = $(this).data('user-id'); // Mendapatkan user_id dari atribut data
            var kegiatanId = '{{ $kegiatan->id }}'; // Mendapatkan kegiatan_id dari template Blade

            // Mengirim data ke server menggunakan AJAX
            $.ajax({
                url: '/absensi/' + kegiatanId + '/' + userId + '/update', // Endpoint untuk update status absensi
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Token CSRF untuk keamanan
                    status: status // Status yang akan diperbarui
                },
                success: function(response) {
                    // Jika berhasil, tampilkan pesan
                    if (response.success) {
                        alert('Absensi berhasil diperbarui');
                        location.reload(); // Refresh halaman setelah berhasil
                    }
                },
                error: function(response) {
                    // Jika terjadi error, tampilkan pesan error
                    alert('Terjadi kesalahan saat memperbarui absensi');
                }
            });
        });

        // Simulate QR code scan update (e.g., changing the status to "hadir")
        function updateAttendanceByQRCode(userId, status) {
            var kegiatanId = '{{ $kegiatan->id }}'; // Mendapatkan kegiatan_id dari template Blade

            // Automatically trigger the update in the backend via AJAX
            $.ajax({
                url: '/absensi/' + kegiatanId + '/' + userId + '/update', // Endpoint untuk update status absensi
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Token CSRF untuk keamanan
                    status: status // Status baru dari QR code scan
                },
                success: function(response) {
                    // If the update is successful, update the radio buttons dynamically
                    if (response.success) {
                        $('input[type="radio"][data-user-id="' + userId + '"][value="' + status + '"]').prop('checked', true);
                        alert('Absensi berhasil diperbarui melalui QR code');
                    }
                },
                error: function(response) {
                    alert('Terjadi kesalahan saat memperbarui absensi via QR code');
                }
            });
        }
    });
</script>

@endsection
