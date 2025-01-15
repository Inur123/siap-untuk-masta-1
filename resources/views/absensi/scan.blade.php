@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="">
    <div class="text-center">
        <h1 class="mb-4">Scan QR Code untuk Kegiatan: {{ $kegiatan->nama_kegiatan }}</h1>

        <!-- QR Code Scanner -->
        <div id="qr-reader" style="width: 600px; height: 400px; margin-bottom: 20px;" class="mx-auto"></div>

        <!-- Displaying scan result -->
        <div id="result"></div>
    </div>
</div>

<!-- Load Html5Qrcode Library -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
   function onScanSuccess(decodedText, decodedResult) {
    console.log(`QR Code decoded: ${decodedText}`);

    // Display temporary scan result
    document.getElementById('result').innerHTML = `
        <div class="alert alert-info">
            QR Code berhasil dipindai!<br>
            Data: ${decodedText}
        </div>
    `;

    // Send the QR code data to the server for validation and attendance
    fetch("{{ route('validasi-qr') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            qr_code: decodedText,
            kegiatan_id: {{ $kegiatan->id }}  // Pass kegiatan_id dynamically
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);  // Debugging: Check what data is returned from the server

        if (data.berhasil) {
            let successSound = new Audio("{{ url('sounds/berhasil-absen.wav') }}");
            successSound.play();
            document.getElementById('result').innerHTML = `
                <div class="alert alert-success">
                    <strong>Absensi berhasil!</strong><br>
                    Nama: ${data.name}<br>
                    NIM: ${data.nim}<br>
                    Kegiatan: ${data.kegiatan}  <!-- Display the kegiatan name dynamically -->
                </div>
            `;
        } else if (data.status_error) {
            document.getElementById('result').innerHTML = `
                <div class="alert alert-danger">
                    <strong>Kesalahan:</strong> ${data.status_error}
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Terjadi kesalahan:', error);
        document.getElementById('result').innerHTML = `
            <div class="alert alert-danger">
                Terjadi kesalahan saat memproses absensi. Silakan coba lagi.
            </div>
        `;
    });
}


    window.onload = function() {
        const html5QrCode = new Html5Qrcode("qr-reader");

        html5QrCode.start(
            { facingMode: "environment" },  // Use the rear camera for QR scanning
            { fps: 15, qrbox: { width: 400, height: 400 } },  // Set the size of the QR box
            onScanSuccess  // Callback function when QR code is scanned
        ).catch(err => {
            console.error("Error initializing QR scanner:", err);
            document.getElementById('result').innerHTML = `
                <div class="alert alert-danger">
                    Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.
                </div>
            `;
        });
    };
</script>

@endsection
