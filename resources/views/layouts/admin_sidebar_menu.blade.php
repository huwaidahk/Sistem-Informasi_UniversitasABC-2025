{{-- resources/views/layouts/admin_sidebar_menu.blade.php --}}

{{-- DASHBOARD --}}
<a href="{{ route('admin.dashboard') }}" 
   class="list-group-item list-group-item-action py-3 px-4 fw-bold @if(request()->routeIs('admin.dashboard')) active @endif">
    {{-- fa-tachometer-alt adalah icon Dashboard --}}
    <i class="fas fa-fw fa-tachometer-alt me-3"></i> 
    Dashboard
</a>

{{-- TENDIK (Manajemen Akun) --}}
<a href="{{ route('admin.tendik.index') }}" 
   class="list-group-item list-group-item-action py-3 px-4 fw-bold @if(request()->routeIs('admin.tendik.*')) active @endif">
    {{-- fa-users adalah icon untuk Tendik/Pengguna --}}
    <i class="fas fa-fw fa-users me-3"></i> 
    Tendik
</a>

{{-- DOSEN (Manajemen Data Dosen) --}}
{{-- Route sudah dikoreksi menjadi admin.dosen.index --}}
<a href="{{ route('admin.dosen.index') }}" 
   class="list-group-item list-group-item-action py-3 px-4 fw-bold @if(request()->routeIs('admin.dosen.*')) active @endif">
    {{-- fa-user-tie adalah icon Dosen --}}
    <i class="fas fa-fw fa-user-tie me-3"></i> 
    Dosen
</a>

{{-- MATA KULIAH (Manajemen Data Mata Kuliah) --}}
{{-- Route sudah dikoreksi menjadi admin.matakuliah.index --}}
<a href="{{ route('admin.matakuliah.index') }}" 
   class="list-group-item list-group-item-action py-3 px-4 fw-bold @if(request()->routeIs('admin.matakuliah.*')) active @endif">
    {{-- fa-book adalah icon Mata Kuliah --}}
    <i class="fas fa-fw fa-book me-3"></i> 
    Mata Kuliah
</a>