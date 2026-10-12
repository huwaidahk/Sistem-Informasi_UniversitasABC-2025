{{-- resources/views/tendik/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard Tendik')

@section('content')
    <h1 class="mb-5 display-4 fw-bold" style="color: #581da4ff;">Dashboard Tendik</h1>

    {{-- Kartu Ringkasan Data Tendik --}}
    <div class="d-flex justify-content-center">
        @php
            // Asumsi $dosenCount, $matkulCount dikirim dari TendikController
            $dosenCount = $dosenCount ?? 0;
            $matkulCount = $matkulCount ?? 0;
            
            $dataCards = [
                ['count' => $dosenCount, 'label' => 'Dosen yang Diinput', 'icon' => 'fa fa-user-tie'],
                ['count' => $matkulCount, 'label' => 'Mata Kuliah yang Diinput', 'icon' => 'fa fa-book-open'],
            ];
            $cardBgStyle = "background-color: #5a3698; border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.5);";
        @endphp

        @foreach ($dataCards as $card)
            <div class="col-5 mb-4 me-5">
                <div class="card p-4 border-0" style="{{ $cardBgStyle }}">
                    <div class="d-flex align-items-center">
                        <i class="{{ $card['icon'] }} fa-4x me-4 text-white-50"></i>
                        <div>
                            <p class="mb-1 text-white-75" style="font-size: 1em;">{{ $card['label'] }}</p>
                            <h2 class="display-4 fw-bold mb-0" style="color: white;">
                                {{ $card['count'] }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    {{-- Aksi Cepat --}}
    <div class="mt-5">
        <h4 class="fw-bold" style="color: #581da4ff;">Aksi Cepat</h4>
        
        {{-- 1. KOREKSI: Input Dosen Baru (Route CRUD) --}}
        <a href="{{ route('tendik.dosen.create') }}" class="btn btn-purple py-3 px-4 me-3">
            <i class="fa fa-user-plus me-2"></i> Input Dosen Baru
        </a>
        
        {{-- 2. KOREKSI: Input Mata Kuliah (Route CRUD) --}}
        <a href="{{ route('tendik.matakuliah.create') }}" class="btn btn-purple py-3 px-4 me-3">
            <i class="fa fa-plus me-2"></i> Input Mata Kuliah
        </a>
        
        <a href="{{ route('tendik.rekap') }}" class="btn btn-secondary py-3 px-4">
            <i class="fa fa-table me-2"></i> Lihat Rekap Data
        </a>
    </div>

    {{-- Detail Statistik --}}
    <div class="card p-4 mt-5 border-0" 
         style="background-color: #31065f; border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.5);">
        
        <h4 class="mb-4 text-white"><i class="fa fa-info-circle me-2"></i> Detail Aktivitas</h4>
        
        <p class="text-white-50">
            Selamat datang, {{ Auth::user()->name ?? 'Tenaga Pendidik' }}. Gunakan navigasi di samping atau tombol Aksi Cepat untuk mulai mengelola data akademik.
        </p>
        
        {{-- Contoh Tabel Informasi --}}
        <table class="table table-dark table-sm mt-3">
            <tbody>
                <tr style="background-color: #411d73;">
                    <td class="text-white-50">Total Data Diinput</td>
                    <td>{{ $dosenCount + $matkulCount }}</td>
                </tr>
                <tr style="background-color: #411d73;">
                    <td class="text-white-50">Aktivitas Terakhir</td>
                    <td>
                                @if ($latestTime)
                                    {{-- Menampilkan Waktu dan Jenis Aktivitas --}}
                                    {{ $latestTime->format('H:i') }} WIB ({{ $latestActivity }})
                                @else
                                    Belum ada aktivitas input
                                @endif
                            </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection