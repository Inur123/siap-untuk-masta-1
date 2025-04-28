@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1>Create Pemandu</h1>

    <form action="{{ route('admin.store_operator') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="nim">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}" required>
            @error('nim')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="nohp">No Hp</label>
            <input type="text" class="form-control" id="nohp" name="nohp" value="{{ old('nohp') }}" required>
            @error('nohp')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="kelompok">Kelompok</label>
            <input type="text" class="form-control" id="kelompok" name="kelompok" value="{{ old('kelompok') }}" required>
            @error('kelompok')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Fakultas Dropdown -->
        <div class="form-group mb-3">
            <label for="fakultas">Fakultas</label>
            <select id="fakultas" name="fakultas" class="form-control @error('fakultas') is-invalid @enderror" required>
                <option value="">-- Select Fakultas --</option>
                <option value="Teknik" {{ old('fakultas') == 'Teknik' ? 'selected' : '' }}>TEKNIK</option>
                <option value="fai" {{ old('fakultas') == 'fai' ? 'selected' : '' }}>FAI</option>
                <option value="Ekonomi" {{ old('fakultas') == 'Ekonomi' ? 'selected' : '' }}>EKONOMI</option>
                <option value="Hukum" {{ old('fakultas') == 'Hukum' ? 'selected' : '' }}>HUKUM</option>
                <option value="fik" {{ old('fakultas') == 'fik' ? 'selected' : '' }}>FIK</option>
                <option value="fisip" {{ old('fakultas') == 'fisip' ? 'selected' : '' }}>FISIP</option>
                <option value="fkip" {{ old('fakultas') == 'fkip' ? 'selected' : '' }}>FKIP</option>
            </select>
            @error('fakultas')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Prodi Dropdown -->
        <div class="form-group mb-3">
            <label for="prodi">Prodi</label>
            <select id="prodi" name="prodi" class="form-control @error('prodi') is-invalid @enderror" required>
                <option value="">-- Select Prodi --</option>
                @php
                    $fakultasProdiMap = [
                        'Teknik' => ['Teknik Informatika', 'Teknik Mesin', 'Teknik Elektro'],
                        'fai' => ['Pgmi', 'Pendidikan Agama Islam', 'Psikologi Islam', 'Ipii', 'Ekonomi Syariah'],
                        'Ekonomi' => ['S1 Akuntansi', 'Manajemen', 'Ekonomi Pembangunan', 'D3 Akuntansi'],
                        'Hukum' => ['Ilmu Hukum'],
                        'fik' => ['Kebidanan', 'Fisioterapi', 'S1 Keperawatan', 'D3 Keperawatan'],
                        'fisip' => ['Ilmu Pemerintahan', 'Ilmu Komunikasi'],
                        'fkip' => ['Pendidikan Bahasa Inggris', 'Pendidikan Matematika', 'Ppkn', 'Pgpaud']
                    ];

                    $currentFakultas = old('fakultas');
                    $currentProdi = old('prodi');

                    if ($currentFakultas && isset($fakultasProdiMap[$currentFakultas])) {
                        foreach ($fakultasProdiMap[$currentFakultas] as $prodi) {
                            echo '<option value="' . $prodi . '" ' . ($currentProdi == $prodi ? 'selected' : '') . '>' . $prodi . '</option>';
                        }
                    }
                @endphp
            </select>
            @error('prodi')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>



        <p class="text-muted mb-3">Password is set to <strong>'password'</strong> by default.</p>

        <button type="submit" class="btn btn-primary">Create Operator</button>
    </form>
</div>

<script>
    const fakultasProdiMap = {
        'Teknik': ['Teknik Informatika', 'Teknik Mesin', 'Teknik Elektro'],
        'fai': ['Pgmi', 'Pendidikan Agama Islam', 'Psikologi Islam', 'Ipii', 'Ekonomi Syariah'],
        'Ekonomi': ['S1 Akuntansi', 'Manajemen', 'Ekonomi Pembangunan', 'D3 Akuntansi'],
        'Hukum': ['Ilmu Hukum'],
        'fik': ['Kebidanan', 'Fisioterapi', 'S1 Keperawatan', 'D3 Keperawatan'],
        'fisip': ['Ilmu Pemerintahan', 'Ilmu Komunikasi'],
        'fkip': ['Pendidikan Bahasa Inggris', 'Pendidikan Matematika', 'Ppkn', 'Pgpaud']
    };

    document.getElementById('fakultas').addEventListener('change', function() {
        const selectedFakultas = this.value;
        const prodiSelect = document.getElementById('prodi');
        const currentProdi = "{{ old('prodi') }}";

        // Clear current options
        prodiSelect.innerHTML = '<option value="">-- Select Prodi --</option>';

        if (fakultasProdiMap[selectedFakultas]) {
            fakultasProdiMap[selectedFakultas].forEach(function(prodi) {
                const option = document.createElement('option');
                option.value = prodi;
                option.textContent = prodi;
                if (prodi === currentProdi) {
                    option.selected = true;
                }
                prodiSelect.appendChild(option);
            });
        }
    });

    // Initialize the prodi dropdown when page loads if fakultas is already selected
    document.addEventListener('DOMContentLoaded', function() {
        const currentFakultas = "{{ old('fakultas') }}";
        if (currentFakultas) {
            document.getElementById('fakultas').value = currentFakultas;
            // Trigger change event to populate prodi dropdown
            const event = new Event('change');
            document.getElementById('fakultas').dispatchEvent(event);
        }
    });
</script>
@endsection
