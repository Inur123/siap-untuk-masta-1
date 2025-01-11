@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1>Sertifikat</h1>
    <p class="text-danger">*Selebelum melakukan Generate pastikan nama sesuai karena generate hanya bisa di lakukan 1X*</p>

    @if ($percentage >= 80 && (!$certificate || !$certificate->is_generated))
    <button id="generateSertifikatBtn" class="btn btn-primary">Generate Sertifikat</button>
@elseif ($percentage < 80)
    <p>Nilai Anda di bawah KKM. Anda perlu mencapai setidaknya 80% untuk mengunduh sertifikat.</p>
@endif


    <!-- Menampilkan Gambar Sertifikat setelah tombol diklik -->
    @if ($certificate && $certificate->is_generated)
        <div id="sertifikatPreview" style="margin-top: 20px;">
            <img src="{{ asset('storage/' . $certificate->certificate_image) }}" id="sertifikatImage" style="max-width: 50%;" alt="Sertifikat Preview" />
        </div>
        <div id="downloadBtn" style="margin-top: 20px;">
            <a href="{{ route('sertifikat.download', ['id' => $certificate->id]) }}" class="btn btn-success" target="_blank">Download Sertifikat</a>
        </div>
    @else
        <div id="sertifikatPreview" style="margin-top: 20px; display: none;">
            <img src="" id="sertifikatImage" style="max-width: 50%;" alt="Sertifikat Preview" />
        </div>
        <div id="downloadBtn" style="margin-top: 20px; display: none;">
            <a href="#" class="btn btn-success" target="_blank">Download Sertifikat</a>
        </div>
    @endif
</div>

<script>
    document.getElementById('generateSertifikatBtn')?.addEventListener('click', function() {
        // Mengirim permintaan untuk generate sertifikat
        fetch("{{ route('sertifikat.generate') }}")
            .then(response => response.json())
            .then(data => {
                // Menampilkan gambar preview sertifikat setelah tombol diklik
                const sertifikatPreview = document.getElementById('sertifikatPreview');
                const sertifikatImage = document.getElementById('sertifikatImage');
                sertifikatImage.src = data.image;

                // Menampilkan gambar dan tombol download
                sertifikatPreview.style.display = 'block';
                document.getElementById('downloadBtn').style.display = 'block';

                // Menyembunyikan tombol Generate setelah sertifikat digenerate
                document.getElementById('generateSertifikatBtn').style.display = 'none';
            })
            .catch(error => {
                alert("Error generating certificate.");
            });
    });
</script>
@endsection
