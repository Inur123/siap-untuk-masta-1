<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password - MASTAMARU 2025</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="{{ asset('template/assets/images/logo-masta24.png') }}" />

    <!-- FontAwesome JS-->
    <script defer src="{{ asset('template/assets/plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('template/assets/css/portal.css') }}">
</head>

<body class="app app-login p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4">
                        <a class="app-logo" href="index.html">
                            <img class="logo-icon me-2" src="{{ asset('template/assets/images/logo-masta24.png') }}" alt="logo">
                        </a>
                    </div>
                    <h2 class="auth-heading text-center mb-5">Reset Password</h2>

                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="auth-form-container text-start">
                        <form class="auth-form login-form text-black" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="email mb-3">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control signin-email" placeholder="Email" required value="{{ old('email') }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Kirim Tautan Reset</button>
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
</body>
</html>
