@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h2>Data Absensi - Kelompok {{ $operator->kelompok }}</h2>

</div>
@endsection
