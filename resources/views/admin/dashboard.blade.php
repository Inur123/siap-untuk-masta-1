@extends('layouts.app')
@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container-xl">
    <h1 class="app-page-title">Dashboard</h1>

    <div
      class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration"
      role="alert"
    >
      <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
          <h3 class="mb-3">Selamat Datang, {{ $user->name }}!</h3>
          <div class="row gx-5 gy-3">
            <div class="col-12 col-lg-9">
              <div>
                Selamat datang di MASTAMARU 2025. Silahkan gunakan fitur yang telah disediakan untuk mempermudah kegiatan anda.
              </div>
            </div>
          </div>
          <!--//row-->
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
          ></button>
        </div>
        <!--//app-card-body-->
      </div>
      <!--//inner-->
    </div>
    <!--//app-card-->

    <div class="row g-4 mb-4">
      <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
          <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Total User</h4>
            <div class="stats-figure">{{ $totalUsers }}</div>

          </div>
          <!--//app-card-body-->
          <a class="app-card-link-mask" href="#"></a>
        </div>
        <!--//app-card-->
      </div>
      <!--//col-->

      <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
          <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Total Pemandu</h4>
            <div class="stats-figure">{{ $totalOperator }}</div>
          </div>
          <!--//app-card-body-->
          <a class="app-card-link-mask" href="{{ url('admin/operators') }}"></a>
        </div>
        <!--//app-card-->
      </div>
      <!--//col-->
      <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
          <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Total Mahasiswa</h4>
            <div class="stats-figure">{{ $totalMahasiswa }}</div>

          </div>
          <!--//app-card-body-->
          <a class="app-card-link-mask" href="{{ url('admin/mahasiswa') }}"></a>
        </div>
        <!--//app-card-->
      </div>
      <!--//col-->
      <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
          <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Total Kelompok</h4>
            <div class="stats-figure">{{ $totalGroups }}</div>

          </div>
          <!--//app-card-body-->
          <a class="app-card-link-mask" href="{{ url('admin/groups') }}"></a>
        </div>
        <!--//app-card-->
      </div>
      <!--//col-->
    </div>
  </div>
@endsection
