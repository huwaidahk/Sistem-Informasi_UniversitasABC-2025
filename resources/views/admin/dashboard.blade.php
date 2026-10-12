{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.app') {{-- Menggunakan layout utama dengan sidebar --}}

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="mb-5 display-4 fw-bold" style="color: #581da4ff;">Dashboard</h1>

    {{-- 1. Kartu Ringkasan Data --}}
    <div class="row">
        @php 
            // Variabel ini datang dari AdminController: $today, $thisMonth, $thisYear, $tendikCount
            $dataCards = [
                ['count' => $today ?? 0, 'label' => 'Jumlah mata kuliah aktif hari ini', 'icon' => 'fas fa-calendar-day'],
                ['count' => $thisMonth ?? 0, 'label' => 'Jumlah mata kuliah aktif bulan ini', 'icon' => 'fas fa-calendar-alt'],
                ['count' => $thisYear ?? 0, 'label' => 'Jumlah mata kuliah aktif tahun ini', 'icon' => 'fas fa-calendar-check'],
                ['count' => $tendikCount ?? 0, 'label' => 'Total Akun Tenaga Pendidik', 'icon' => 'fas fa-users'],
            ];
            // Styling kartu ungu gelap dengan sedikit gradasi
            $cardBgStyle = "background-color: #5a3698; background-image: linear-gradient(135deg, #704dbaff 0%, #4a2b85 100%); border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.5);";
        @endphp
        
        @foreach ($dataCards as $card)
            <div class="col-md-3 mb-4">
                <div class="card p-4 text-center border-0" style="{{ $cardBgStyle }}">
                    <i class="{{ $card['icon'] }} fa-3x mb-3 text-white-50"></i>
                    {{-- Angka Besar --}}
                    <h2 class="display-4 fw-bold mb-1" style="color: white; text-shadow: 0 0 5px rgba(255,255,255,0.3);">
                        {{ $card['count'] }}
                    </h2>
                    {{-- Teks Deskripsi --}}
                    <p class="mb-0 text-white-75" style="font-size: 0.9em;">
                        {{ $card['label'] }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    
    {{-- Garis Pemisah --}}
    <hr class="my-5 border-secondary" style="background-color: #31065f; height: 3px; opacity: 1;">

    {{-- 2. Grafik Batang (Bar Chart) dan Detail Aktivitas --}}
    <div class="row">
        {{-- Kolom Kiri: Grafik --}}
        <div class="col-md-7 mb-4">
            <div class="card p-4 border-0" 
                 style="background-color: #31065f; border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.5);">
                
                <h4 class="mb-4 text-white"><i class="fas fa-chart-bar me-2"></i> Rekap Mata Kuliah Aktif (Tahunan)</h4>
                
                <div style="height: 350px;">
                    <canvas id="mataKuliahChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Detail Aktivitas --}}
        <div class="col-md-5 mb-4">
            <div class="card p-4 border-0" 
                 style="background-color: #31065f; border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.5);">
                
                <h4 class="mb-4 text-white"><i class="fas fa-info-circle me-2"></i> Detail Aktivitas</h4>
                
                <table class="table table-dark table-sm mt-3">
                    <tbody>
                        <tr style="background-color: #411d73;">
                            <td class="text-white-50">Total Mata Kuliah</td>
                            {{-- KOREKSI DI SINI: Ganti penjumlahan dengan variabel total Matkul --}}
                            <td>{{ $totalMatkulCount ?? 0 }}</td> 
                        </tr>
                        <tr style="background-color: #411d73;">
                            <td class="text-white-50">Total Akun Tendik</td>
                            <td>{{ $tendikCount }}</td>
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
        </div>
    </div>
@endsection

{{-- Skrip untuk Chart.js --}}
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Mengambil data (asumsi $chartData dikirim dari controller)
        const chartData = {
            hari: {{ $chartData['hari'] ?? 0 }},
            bulan: {{ $chartData['bulan'] ?? 0 }},
            tahun: {{ $chartData['tahun'] ?? 0 }}
        };

        const ctx = document.getElementById('mataKuliahChart');
        const barColor = 'rgba(111, 66, 193, 0.8)'; 
        const fontColor = '#f8f9fa';

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Hari Ini', 'Bulan Ini', 'Tahun Ini'],
                datasets: [{
                    label: 'Jumlah Mata Kuliah',
                    data: [chartData.hari, chartData.bulan, chartData.tahun],
                    backgroundColor: barColor,
                    borderColor: 'white',
                    borderWidth: 0,
                    borderRadius: 5,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: fontColor },
                        grid: { color: 'rgba(255, 255, 255, 0.1)', drawBorder: false }
                    },
                    x: {
                        ticks: { color: fontColor },
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
@endpush