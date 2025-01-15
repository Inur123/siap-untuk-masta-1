@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection
<style>
    input[type="number"]::-webkit-outer-spin-button,
       input[type="number"]::-webkit-inner-spin-button {
         -webkit-appearance: none;
         margin: 0;
       }

       input[type="number"] {
         -moz-appearance: textfield; /* Untuk Firefox */
       }
</style>
@section('content')
<div class="container mt-2">
    <h1 class="mb-4">Create Pemandu</h1>

    <form action="{{ route('admin.store_operator') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- NIM -->
        <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="number" class="form-control" id="nim" name="nim" required>
        </div>

        <!-- Kelompok -->
        <div class="mb-3">
            <label for="kelompok" class="form-label">Kelompok</label>
            <input type="text" class="form-control" id="kelompok" name="kelompok">
        </div>

        <!-- Fakultas -->
        <div class="mb-3">
            <label for="fakultas" class="form-label">Fakultas</label>
            <select id="fakultas" name="fakultas"
            class="form-control @error('fakultas') is-invalid @enderror" required>
            <option value="">-- Select Fakultas --</option>
            <option value="Teknik" {{ old('fakultas') == 'Teknik' ? 'selected' : '' }}>TEKNIK</option>
            <option value="fai" {{ old('fakultas') == 'fai' ? 'selected' : '' }}>FAI</option>
            <option value="Ekonomi" {{ old('fakultas') == 'Ekonomi' ? 'selected' : '' }}>EKONOMI</option>
            <option value="Hukum" {{ old('fakultas') == 'Hukum' ? 'selected' : '' }}>HUKUM</option>
            <option value="fik" {{ old('fakultas') == 'fik' ? 'selected' : '' }}>FIK</option>
            <option value="fisip" {{ old('fakultas') == 'fisip' ? 'selected' : '' }}>FISIP</option>
            <option value="fkip" {{ old('fakultas') == 'fkip' ? 'selected' : '' }}>FKIP</option>
        </select>
        </div>

        <!-- Prodi -->
        <div class="mb-3">
            <label for="prodi" class="form-label">Prodi</label>
            <select id="prodi" name="prodi"
            class="form-control @error('prodi') is-invalid @enderror" required>
            <option value="">-- Select Prodi --</option>
        </select>
        </div>

        <!-- Password Information -->
        <p class="text-muted">Password is set to <strong>'password'</strong> by default.</p>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Create Operator</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fakultasProdiMap = {
            'Teknik': ['Teknik Informatika', 'Teknik Mesin', 'Teknik Elektro'],
            'fai': ['Pgmi', 'Pendidikan Agama Islam', 'Psikologi Islam', 'Ipii', 'Ekonomi Syariah'],
            'Ekonomi': ['S1 Akuntansi', 'Manajemen', 'Ekonomi Pembangunan', 'D3 Akuntansi'],
            'Hukum': ['Ilmu Hukum'],
            'fik': ['Kebidanan', 'Fisioterapi', 'S1 Keperawatan', 'D3 Keperawatan'],
            'fisip': ['Ilmu Pemerintahan', 'Ilmu Komunikasi'],
            'fkip': ['Pendidikan Bahasa Inggris', 'Pendidikan Matematika', 'Ppkn', 'Pgpaud']
        };

        const fakultasSelect = document.getElementById('fakultas');
        const prodiSelect = document.getElementById('prodi');
        const oldFakultas = "{{ old('fakultas') }}";
        const oldProdi = "{{ old('prodi') }}";

        // Populate Prodi based on old Fakultas value
        if (oldFakultas && fakultasProdiMap[oldFakultas]) {
            fakultasProdiMap[oldFakultas].forEach(function (prodi) {
                const option = document.createElement('option');
                option.value = prodi;
                option.textContent = prodi;
                if (prodi === oldProdi) {
                    option.selected = true;
                }
                prodiSelect.appendChild(option);
            });
        }

        fakultasSelect.addEventListener('change', function () {
            const selectedFakultas = this.value;

            // Clear current options
            prodiSelect.innerHTML = '<option value="">-- Select Prodi --</option>';

            if (fakultasProdiMap[selectedFakultas]) {
                fakultasProdiMap[selectedFakultas].forEach(function (prodi) {
                    const option = document.createElement('option');
                    option.value = prodi;
                    option.textContent = prodi;
                    prodiSelect.appendChild(option);
                });
            }
        });
    });
</script>
@endsection
