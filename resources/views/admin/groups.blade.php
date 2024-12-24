@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Data Kelompok Mahasiswa</h1>
        <a href="{{ route('admin.exportUsers') }}" class="btn btn-success mb-2">Export Users to Excel</a>
        <a href="{{ route('admin.exportUsersToWord') }}" class="btn btn-info mb-2">Export Users to Word</a>

        @php
        // Sort the $groupDetails array by the 'kelompok' field
        usort($groupDetails, function($a, $b) {
            return (int)$a['kelompok'] <=> (int)$b['kelompok'];
        });
        @endphp

        <!-- Row to display groups in two columns -->
        <div class="row">
            @foreach ($groupDetails as $group)
                <div class="col-12 col-sm-6 mb-4">
                    <div class="bg-white border border-gray-300 p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <h2 class="text-lg font-semibold mb-2">Kelompok: {{ $group['kelompok'] }} (Fakultas: {{ $group['fakultas'] }})</h2>

                        <!-- Table of members in the group -->
                        <table class="min-w-full bg-white border border-gray-300 mb-4">
                            <thead>
                                <tr>
                                    <th class="px-2 py-1 text-left text-sm">NIM</th>
                                    <th class="px-2 py-1 text-left text-sm">Nama</th>
                                    <th class="px-2 py-1 text-left text-sm">Fakultas</th>
                                    <th class="px-2 py-1 text-left text-sm">Prodi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($group['members'] as $member)
                                    <tr>
                                        <td class="border px-2 py-1 text-sm">{{ $member->nim }}</td>
                                        <td class="border px-2 py-1 text-sm">{{ explode(' ', $member->name)[0] }}</td>
                                        <td class="border px-2 py-1 text-sm">{{ $member->fakultas }}</td>
                                        <td class="border px-2 py-1 text-sm">{{ $member->prodi }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('admin.groupDetail', $group['kelompok']) }}" class="text-blue-500 hover:underline">
                            Lihat Detail Kelompok
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
