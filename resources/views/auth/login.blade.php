<!DOCTYPE html>
<html lang="en">
<head>
    <title>MASTAMARU 2025</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="{{ asset('template/assets/images/logo-masta24.png') }}"" />

    <!-- FontAwesome JS-->
    <script defer src="{{ asset('template/assets/plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('template/assets/css/portal.css') }}">
    <style>
        /* Menghilangkan tombol up/down pada input number */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }

        input[type="number"] {
          -moz-appearance: textfield; /* Untuk Firefox */
        }

        .eye-icon {
          position: absolute;
          right: 10px;
          top: 50%;
          transform: translateY(-50%);
          cursor: pointer;
        }
    </style>
</head>

<body class="app app-login p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img class="logo-icon me-2" src="{{ asset('template/assets/images/logo-masta24.png') }}" alt="logo"></a></div>
                    <h2 class="auth-heading text-center mb-5">Log in</h2>
                    <div class="auth-form-container text-start">
                        <form class="auth-form login-form text-black" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="email mb-3">
                                <label for="nim">Nim</label>
                                <input id="nim" name="nim" type="number" class="form-control signin-email" placeholder="Nim" required value="{{ old('nim') }}">
                                @error('nim')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="password mb-3 position-relative">
                                <label for="password">Password</label>
                                <input id="password" name="password" type="password" class="form-control signin-password" placeholder="Password" required value="{{ old('password') }}">
                                <i class="fa fa-eye eye-icon" id="togglePassword" onclick="togglePasswordVisibility()"></i>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="g-recaptcha mb-3" data-sitekey="{{ config('services.recaptcha.sitekey') }}"></div>
                            @error('g-recaptcha-response')
                                <small class="text-danger ">{{ $message }}</small>
                            @enderror
                            <div class="text-center">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log In</button>
                            </div>
                        </form>

                        <div class="auth-option text-center pt-2">Belum punya akun?  <a class="text-link" href="/register" >Daftar</a>.</div>
                    </div><!--//auth-form-container-->

                </div><!--//auth-body-->

                <footer class="app-auth-footer">
                    <div class="container text-center py-3">
                        <small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #ff4e21;"></i> by <a class="app-link" href="#" target="_blank">Panitia Mastamaru 2025</a> for developers</small>
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

    <script src="https://www.google.com/recaptcha/api.js"></script>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('togglePassword');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
