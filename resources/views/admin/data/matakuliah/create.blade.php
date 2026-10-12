{{-- resources/views/admin/data/matakuliah/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Mata Kuliah')

@section('content')
    <h1 class="display-4 fw-bold mb-4" style="color: #581da4ff;">Menu Data Mata Kuliah</h1>

    <div class="card p-5 border-0" style="background-color: #31065f; border-radius: 15px;">
        <h4 class="text-white mb-4">Tambah Matkul</h4>
        <form method="POST" action="{{ route('admin.matakuliah.store') }}">
            @csrf
            
            <div class="mb-4">
                <label for="kode_matkul" class="form-label text-white">Kode MK</label>
                {{-- KOREKSI UTAMA: Ubah name="id" menjadi name="kode_matkul" --}}
                <input type="text" name="kode_matkul" id="kode_matkul" class="form-control form-control-custom" value="{{ old('kode_matkul') }}" required>
                {{-- KOREKSI: Ubah @error('id') menjadi @error('kode_matkul') --}}
                @error('kode_matkul') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="nama_matkul" class="form-label text-white">Nama Matkul</label>
                <input type="text" name="nama_matkul" id="nama_matkul" class="form-control form-control-custom" value="{{ old('nama_matkul') }}" required>
                @error('nama_matkul') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="sks" class="form-label text-white">SKS</label>
                <input type="number" name="sks" id="sks" class="form-control form-control-custom" value="{{ old('sks') }}" min="1" required>
                @error('sks') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="mb-4">
                <label for="dosens" class="form-label text-white">Dosen Pengampu</label>
                <select name="dosens[]" id="dosens" 
                    class="form-select form-control-custom" 
                    multiple required>
                
                <option value="" disabled>-- Pilih Dosen Pengampu (Bisa lebih dari satu) --</option>
                
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->id }}" 
                            {{-- Di form CREATE, kita hanya perlu mengecek nilai old (jika validasi gagal) --}}
                            {{ in_array($dosen->id, old('dosens', [])) ? 'selected' : '' }}>
                        {{ $dosen->nama_dosen }} ({{ $dosen->nidn }})
                    </option>
                @endforeach
            </select>
            @error('dosens') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label text-white">Tanggal Input</label>
                <input type="text" class="form-control form-control-custom" value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" disabled>
            </div>

            <button type="submit" class="btn btn-success me-2" style="background-color: #198754; border-color: #198754;">Simpan</button>
            <a href="{{ route('admin.matakuliah.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection