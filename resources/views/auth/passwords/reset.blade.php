<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - MASTAMARU 2025</title>

    <!-- Meta -->
    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="{{ asset('template/assets/images/logo-masta24.png') }}" />

    <!-- FontAwesome JS-->
    <script defer src="{{ asset('template/assets/plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('template/assets/css/portal.css') }}">

    <style>


        .eye-icon {
          position: absolute;
          right: 10px;
          top: 50%;
          transform: translateY(-50%);
          cursor: pointer;
          z-index: 10; /* Tambahkan z-index agar ikon berada di atas */
        }

        .input-group {
          position: relative;
        }

        .input-group input {
          padding-right: 30px; /* Untuk memberi ruang bagi ikon */
        }
    </style>
</head>

<body class="app app-login p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4">
                        <a class="app-logo" href="#">
                            <img class="logo-icon me-2" src="{{ asset('template/assets/images/logo-masta24.png') }}" alt="logo">
                        </a>
                    </div>
                    <h2 class="auth-heading text-center mb-5">Atur Ulang Password</h2>

                    <!-- Displaying Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="auth-form-container text-start">
                        <form class="auth-form login-form text-black" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden"  name="token" value="{{ request()->token }}">
                            <input  type="hidden" name="email" value="{{ request()->email }}">

                            <div class="password mb-3">
                                <label for="password">Password Baru</label>
                                <div class="input-group">
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password Baru" required>
                                    <i class="fa fa-eye eye-icon" id="togglePassword" onclick="togglePasswordVisibility()"></i>
                                </div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Password Confirmation Input -->
                            <div class="password-confirmation mb-3">
                                <label for="password-confirm">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input id="password-confirm" name="password_confirmation" type="password" class="form-control" placeholder="Konfirmasi Password" required>
                                    <i class="fa fa-eye eye-icon" id="togglePasswordConfirm" onclick="togglePasswordConfirmVisibility()"></i>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Reset Password</button>
                            </div>
                        </form>

                        <div class="auth-option text-center pt-2">
                            Kembali ke <a class="text-link" href="/login">Halaman Login</a>.
                        </div>
                    </div><!--//auth-form-container-->
                </div><!--//auth-body-->
                <footer class="app-auth-footer">
                    <div class="container text-center py-3">
                        <small class="copyright">Designed with <span class="sr-only">love</span>
                            <i class="fas fa-heart" style="color: #ff4e21;"></i> by
                            <a class="app-link" href="#" target="_blank">Panitia Mastamaru 2025</a>
                            for developers
                        </small>
                    </div>
                </footer><!--//app-auth-footer-->
            </div><!--//flex-column-->
        </div><!--//auth-main-col-->
        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
            <div class="auth-background-holder"></div>
            <div class="auth-background-mask"></div>
            <div class="auth-background-overlay p-3 p-lg-5">
                <div class="d-flex flex-column align-content-end h-100">
                    <div class="h-100"></div>
                </div>
            </div><!--//auth-background-overlay-->
        </div><!--//auth-background-col-->
    </div><!--//row-->

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('togglePassword');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.add('fa-eye-slash');
                eyeIcon.classList.remove('fa-eye');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.add('fa-eye');
                eyeIcon.classList.remove('fa-eye-slash');
            }
        }

        function togglePasswordConfirmVisibility() {
            const passwordConfirmField = document.getElementById('password-confirm');
            const eyeIcon = document.getElementById('togglePasswordConfirm');
            if (passwordConfirmField.type === 'password') {
                passwordConfirmField.type = 'text';
                eyeIcon.classList.add('fa-eye-slash');
                eyeIcon.classList.remove('fa-eye');
            } else {
                passwordConfirmField.type = 'password';
                eyeIcon.classList.add('fa-eye');
                eyeIcon.classList.remove('fa-eye-slash');
            }
        }
    </script>
</body>
</html>
