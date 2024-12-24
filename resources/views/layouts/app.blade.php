<!DOCTYPE html>
<html lang="en">
  <head>
    <title>MASTAMARU 2025</title>

    <!-- Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta
      name="description"
      content="Portal - Bootstrap 5 Admin Dashboard Template For Developers"
    />

    <link rel="shortcut icon" href="{{ asset('template/assets/images/logo-masta24.png') }}"" />

    <!-- FontAwesome JS-->
    <script defer src="{{ asset('template/assets/plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('template/assets/css/portal.css') }}" />


  </head>

  <body class="app">

        @yield('navbar')

        @section('sidebar')
        @show

        <div class="app-wrapper">
            <div class="app-content pt-3 p-md-3 p-lg-4">

                        @yield('content')

            </div>
        </div>

    <footer class="app-footer">
        <div class="container text-center py-3">
          <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
          <small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #ff4e21;"></i> by <a class="app-link" href="#" target="_blank">Panitia Mastamaru 2025</a> for developers </small>

        </div>
      </footer>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('template/assets/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('template/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>


    <!-- Charts JS -->
    <script src="{{ asset('template/assets/plugins/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/index-charts.js') }}"></script>

    <!-- Page Specific JS -->
    <script src="{{ asset('template/assets/js/app.js') }}"></script>
  </body>
</html>

