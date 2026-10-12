<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Informasi Universitas ABC')</title>
    
    {{-- Hubungkan Assets Vite (SCSS & JS) --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Masukkan CDN Font Awesome untuk icon (Opsional, jika belum di-load via Vite) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* CSS Kustom untuk Layout */
        #wrapper {
            display: flex;
            min-height: 100vh;
        }
        #sidebar-wrapper {
            width: 250px;
            background-color: #31065f; /* Warna Sidebar Ungu Gelap */
            color: #f8f9fa;
        }
        #page-content-wrapper {
            flex-grow: 1;
            padding: 30px;
            background-color: #b285edff; /* Warna Konten Utama Hitam Gelap */
        }
        .list-group-item {
            background-color: transparent !important;
            color: #f8f9fa;
            border: none;
        }
        .list-group-item.active {
            background-color: #6f42c1 !important; /* Warna Ungu Primer */
        }
    </style>
</head>
<body>
    <div id="wrapper">
        {{-- Sidebar --}}
        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 fs-4 border-bottom border-secondary fw-bold" style="color: #b088f9ff;">
                Universitas ABC
            </div>
            <div class="list-group list-group-flush">
                {{-- Cek Role untuk menampilkan Menu --}}
                @auth
                    {{-- Menggunakan strtolower untuk keamanan, meskipun sudah di AuthController --}}
                    @if (strtolower(Auth::user()->role) == 'administrator') 
                        @include('layouts.admin_sidebar_menu')
                    @elseif (strtolower(Auth::user()->role) == 'tendik')
                        @include('layouts.tendik_sidebar_menu')
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="list-group-item list-group-item-action py-3 d-flex align-items-center">
                            <i class="fa fa-sign-out me-2"></i> Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>

        {{-- Page Content --}}
        <div id="page-content-wrapper">
            @yield('content')
        </div>
    </div>
    
    {{-- PENTING: TAG INI MEMASTIKAN KODE JAVASCRIPT DARI @PUSH('scripts') DIJALANKAN --}}
    @stack('scripts') 

</body>
</html>