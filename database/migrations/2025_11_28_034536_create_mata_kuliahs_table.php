<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_matkul', 10)->unique();
            $table->string('nama_matkul');
            $table->integer('sks')->default(3); 
            
            // --- KOLOM DOSEN_ID DIHAPUS DARI SINI ---
            
            // Foreign Key ke User (Tendik/Admin yang menginput)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null'); 
                  
            $table->timestamps();
        });
        
        // ... (sisa code untuk tabel lain) ...
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_kuliahs');
        // ... (sisa dropIfExists) ...
    }
};