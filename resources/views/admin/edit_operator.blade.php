@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1 class="text-center">Edit Pemandu</h1>
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.update_operator', $operator->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name', $operator->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- NIM Field -->
                <div class="form-group mb-3">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control @error('nim') is-invalid @enderror"
                           id="nim" name="nim" value="{{ old('nim', $operator->nim) }}" required>
                    @error('nim')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Phone Number Field -->
                <div class="form-group mb-3">
                    <label for="nohp">No Hp</label>
                    <input type="number" class="form-control @error('nohp') is-invalid @enderror"
                           id="nohp" name="nohp" value="{{ old('nohp', $operator->nohp) }}" required>
                    @error('nohp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Group Field -->
                <div class="form-group mb-3">
                    <label for="kelompok">Kelompok</label>
                    <input type="text" class="form-control @error('kelompok') is-invalid @enderror"
                           id="kelompok" name="kelompok" value="{{ old('kelompok', $operator->kelompok) }}">
                    @error('kelompok')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Faculty Dropdown -->
                <div class="form-group mb-3">
                    <label for="fakultas">Fakultas</label>
                    <select id="fakultas" name="fakultas"
                            class="form-control @error('fakultas') is-invalid @enderror" required>
                        <option value="">-- Select Fakultas --</option>
                        <option value="Teknik" {{ old('fakultas', $operator->fakultas) == 'Teknik' ? 'selected' : '' }}>TEKNIK</option>
                        <option value="fai" {{ old('fakultas', $operator->fakultas) == 'fai' ? 'selected' : '' }}>FAI</option>
                        <option value="Ekonomi" {{ old('fakultas', $operator->fakultas) == 'Ekonomi' ? 'selected' : '' }}>EKONOMI</option>
                        <option value="Hukum" {{ old('fakultas', $operator->fakultas) == 'Hukum' ? 'selected' : '' }}>HUKUM</option>
                        <option value="fik" {{ old('fakultas', $operator->fakultas) == 'fik' ? 'selected' : '' }}>FIK</option>
                        <option value="fisip" {{ old('fakultas', $operator->fakultas) == 'fisip' ? 'selected' : '' }}>FISIP</option>
                        <option value="fkip" {{ old('fakultas', $operator->fakultas) == 'fkip' ? 'selected' : '' }}>FKIP</option>
                    </select>
                    @error('fakultas')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Study Program Dropdown -->
                <div class="form-group mb-3">
                    <label for="prodi">Prodi</label>
                    <select id="prodi" name="prodi"
                            class="form-control @error('prodi') is-invalid @enderror" required>
                        <option value="">-- Select Prodi --</option>
                        @php
                            $currentFakultas = old('fakultas', $operator->fakultas);
                            $currentProdi = old('prodi', $operator->prodi);

                            if ($currentFakultas && isset($fakultasProdiMap[$currentFakultas])) {
                                foreach ($fakultasProdiMap[$currentFakultas] as $prodi) {
                                    echo '<option value="'.$prodi.'" '.($currentProdi == $prodi ? 'selected' : '').'>'.$prodi.'</option>';
                                }
                            }
                        @endphp
                    </select>
                    @error('prodi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Update Operator</button>
            </form>
        </div>
    </div>
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
        const currentProdi = "{{ old('prodi', $operator->prodi) }}";

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

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const currentFakultas = "{{ old('fakultas', $operator->fakultas) }}";
        if (currentFakultas) {
            document.getElementById('fakultas').value = currentFakultas;
            const event = new Event('change');
            document.getElementById('fakultas').dispatchEvent(event);
        }
    });
</script>
@endsection
