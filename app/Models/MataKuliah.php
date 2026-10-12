<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;
    
    protected $table = 'mata_kuliahs';
    
    /**
     * Kolom yang diizinkan diisi secara massal.
     * Kolom dosen_id dihilangkan karena relasi diurus oleh tabel pivot.
     */
    protected $fillable = [
        'kode_matkul',
        'nama_matkul',
        'sks',          
        'user_id',      // Kunci asing ke User (Tendik/Admin yang menginput)
    ];

    // --- RELASI UNTUK DATABASE DAN ATTACH ---

    /**
     * Relasi Many-to-Many ke Dosen (Dosen Pengampu). (PLURAL)
     */
    public function dosens()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_mata_kuliah', 'mata_kuliah_id', 'dosen_id');
    }
    
    /**
     * Relasi Many-to-One ke User (Tendik/Admin yang menginput).
     */
    public function user() 
    {
        return $this->belongsTo(User::class); 
    }

    // --- ACCESSOR UNTUK VIEW (MENGHINDARI ERROR DI BLADE) ---

    /**
     * Accessor yang mengembalikan objek Dosen PERTAMA yang mengampu Mata Kuliah ini.
     * Digunakan di View sebagai $matkul->dosen_pengampu->nama_dosen.
     */
    
    public function getDosenPengampuAttribute()
    {
        return $this->dosens()->first();
    }
    
    // 💡 SOLUSI FINAL UNTUK ERROR 'MataKuliah::with("dosen")'
    // Membuat alias singular 'dosen' yang memanggil relasi belongsToMany. 
    // Ini menyelesaikan RelationNotFoundException di AdminController.
    public function dosen() 
    {
        return $this->dosens();
    }
}