{{-- resources/views/layouts/tendik_sidebar_menu.blade.php --}}

{{-- DASHBOARD --}}
<a href="{{ route('tendik.dashboard') }}" 
   class="list-group-item list-group-item-action py-3 px-4 fw-bold @if(request()->routeIs('tendik.dashboard')) active @endif">
    <i class="fas fa-fw fa-tachometer-alt me-3"></i> 
    Dashboard
</a>

{{-- DOSEN --}}
{{-- Mengarah ke index data dosen --}}
<a href="{{ route('tendik.dosen.index') }}" 
   class="list-group-item list-group-item-action py-3 px-4 fw-bold @if(request()->routeIs('tendik.dosen.*')) active @endif">
    <i class="fas fa-fw fa-user-tie me-3"></i> 
    Dosen
</a>

{{-- MATA KULIAH --}}
{{-- Mengarah ke index data mata kuliah --}}
<a href="{{ route('tendik.matakuliah.index') }}" 
   class="list-group-item list-group-item-action py-3 px-4 fw-bold @if(request()->routeIs('tendik.matakuliah.*')) active @endif">
    <i class="fas fa-fw fa-book me-3"></i> 
    Mata Kuliah
</a>

{{-- REKAP DATA --}}
{{-- Tautan ini sering digunakan untuk melihat rekap inputan Tendik --}}
<a href="{{ route('tendik.rekap') }}" 
   class="list-group-item list-group-item-action py-3 px-4 fw-bold @if(request()->routeIs('tendik.rekap')) active @endif">
    <i class="fas fa-fw fa-table me-3"></i> 
    Rekap Data
</a>