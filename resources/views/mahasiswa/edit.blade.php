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
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@section('content')
<div class="container mt-2">
    <div class="card shadow">
        <div class="card-header text-center bg-primary text-white">
            <h3>Edit Your Data</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('mahasiswa.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <!-- Email Field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <!-- NIM Field -->
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="number" class="form-control" id="nim" name="nim" value="{{ old('nim', $user->nim) }}" required>
                </div>

                <!-- Fakultas Field -->
                <div class="mb-3">
                    <label for="fakultas" class="form-label">Fakultas</label>
                    <select id="fakultas" name="fakultas" class="form-control" required>
                        <option value="">-- Select Fakultas --</option>
                        <option value="Teknik" {{ old('fakultas', $user->fakultas) == 'Teknik' ? 'selected' : '' }}>TEKNIK</option>
                        <option value="fai" {{ old('fakultas', $user->fakultas) == 'fai' ? 'selected' : '' }}>FAI</option>
                        <option value="Ekonomi" {{ old('fakultas', $user->fakultas) == 'Ekonomi' ? 'selected' : '' }}>EKONOMI</option>
                        <option value="Hukum" {{ old('fakultas', $user->fakultas) == 'Hukum' ? 'selected' : '' }}>HUKUM</option>
                        <option value="fik" {{ old('fakultas', $user->fakultas) == 'fik' ? 'selected' : '' }}>FIK</option>
                        <option value="fisip" {{ old('fakultas', $user->fakultas) == 'fisip' ? 'selected' : '' }}>FISIP</option>
                        <option value="fkip" {{ old('fakultas', $user->fakultas) == 'fkip' ? 'selected' : '' }}>FKIP</option>
                    </select>
                </div>

                <!-- Prodi Field -->
                <div class="mb-3">
                    <label for="prodi" class="form-label">Prodi</label>
                    <select id="prodi" name="prodi" class="form-control" required>
                        <option value="">-- Select Prodi --</option>
                        @php
                            $prodiMap = [
                                'Teknik' => ['Teknik Informatika', 'Teknik Mesin', 'Teknik Elektro'],
                                'fai' => ['Pgmi', 'Pendidikan Agama Islam', 'Psikologi Islam', 'Ipii', 'Ekonomi Syariah'],
                                'Ekonomi' => ['S1 Akuntansi', 'Manajemen', 'Ekonomi Pembangunan', 'D3 Akuntansi'],
                                'Hukum' => ['Ilmu Hukum'],
                                'fik' => ['Kebidanan', 'Fisioterapi', 'S1 Keperawatan', 'D3 Keperawatan'],
                                'fisip' => ['Ilmu Pemerintahan', 'Ilmu Komunikasi'],
                                'fkip' => ['Pendidikan Bahasa Inggris', 'Pendidikan Matematika', 'Ppkn', 'Pgpaud'],
                            ];
                            $currentFakultas = old('fakultas', $user->fakultas);
                        @endphp

                        @if(isset($prodiMap[$currentFakultas]))
                            @foreach($prodiMap[$currentFakultas] as $prodi)
                                <option value="{{ $prodi }}" {{ old('prodi', $user->prodi) == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Upload File -->
                <div class="mb-3">
                    <label for="file" class="form-label">Upload File</label>
                    <input type="file" class="form-control" id="file" name="file">
                    @if($user->file)
                        <small class="text-muted">Current file: {{ basename($user->file) }}</small>
                    @endif
                </div>

                <hr>

                <!-- Change Password -->
                <h4 class="mb-3">Change Password</h4>
                <div class="mb-3">
                    <label for="current_password" class="form-label">Password Lama</label>
                    <div class="position-relative">
                        <input type="password" class="form-control pe-5" id="current_password" name="current_password" placeholder="Enter current password">
                        <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-2 toggle-password" data-target="#current_password" style="cursor: pointer;"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <div class="position-relative">
                        <input type="password" class="form-control pe-5" id="new_password" name="new_password" placeholder="Enter new password">
                        <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-2 toggle-password" data-target="#new_password" style="cursor: pointer;"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirm Password Baru</label>
                    <div class="position-relative">
                        <input type="password" class="form-control pe-5" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password">
                        <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-2 toggle-password" data-target="#new_password_confirmation" style="cursor: pointer;"></i>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update Data</button>
                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const fakultasProdiMap = {
        'Teknik': ['Teknik Informatika', 'Teknik Mesin', 'Teknik Elektro'],
        'fai': ['Pgmi', 'Pendidikan Agama Islam','Psikologi Islam','Ipii','Ekonomi Syariah'],
        'Ekonomi': ['S1 Akuntansi', 'Manajemen','Ekonomi Pembangunan','D3 Akuntansi'],
        'Hukum': ['Ilmu Hukum'],
        'fik': ['Kebidanan','Fisioterapi','S1 Keperawatan','D3 Keperawatan'],
        'fisip': ['Ilmu Pemerintahan','Ilmu Komunikasi'],
        'fkip': ['Pendidikan Bahasa Inggris', 'Pendidikan Matematika','Ppkn','Pgpaud']
    };

    document.getElementById('fakultas').addEventListener('change', function() {
        const selectedFakultas = this.value;
        const prodiSelect = document.getElementById('prodi');

        // Clear current options
        prodiSelect.innerHTML = '<option value="">-- Select Prodi --</option>';

        if (fakultasProdiMap[selectedFakultas]) {
            fakultasProdiMap[selectedFakultas].forEach(function(prodi) {
                const option = document.createElement('option');
                option.value = prodi;
                option.textContent = prodi;
                prodiSelect.appendChild(option);
            });
        }
    });
</script>
<script>
    document.querySelectorAll('.input-group-text').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const input = this.parentElement.previousElementSibling;
            const isPassword = input.type === 'password';

            // Toggle input type
            input.type = isPassword ? 'text' : 'password';
            // Toggle icon between eye and eye-slash
            this.querySelector('i').classList.toggle('fa-eye-slash', !isPassword);
            this.querySelector('i').classList.toggle('fa-eye', isPassword);
        });
    });
</script>

{{-- icon mata password --}}
<script>
  document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', function () {
        const targetInput = document.querySelector(this.dataset.target);
        if (targetInput.type === 'password') {
            targetInput.type = 'text';
            this.classList.remove('bi-eye-slash');
            this.classList.add('bi-eye');
        } else {
            targetInput.type = 'password';
            this.classList.remove('bi-eye');
            this.classList.add('bi-eye-slash');
        }
    });
});
</script>

@endsection
