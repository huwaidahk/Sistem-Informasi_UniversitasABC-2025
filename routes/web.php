<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TendikController;
use App\Http\Middleware\RoleMiddleware;

// --- 1. Rute Autentikasi (Login & Register) ---

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// --- 2. Grup Rute yang Memerlukan Autentikasi ---
Route::middleware(['auth'])->group(function () {

    // --- A. Rute Administrator (Tidak Diubah) ---
    Route::middleware([RoleMiddleware::class . ':administrator'])->prefix('admin')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // CRUD Data Tendik (Mengelola Akun User role='tendik')
        Route::resource('tendik', AdminController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])->names([
            'index' => 'admin.tendik.index',
            'create' => 'admin.tendik.create',
            'store' => 'admin.tendik.store',
            'edit' => 'admin.tendik.edit',
            'update' => 'admin.tendik.update',
            'destroy' => 'admin.tendik.destroy',
        ]);
        
        // CRUD Data Dosen
        Route::get('data/dosen/create', [AdminController::class, 'dosenCreate'])->name('admin.dosen.create');
        Route::get('data/dosen', [AdminController::class, 'dosenIndex'])->name('admin.dosen.index');
        Route::post('data/dosen', [AdminController::class, 'dosenStore'])->name('admin.dosen.store');
        Route::get('data/dosen/{dosen}/edit', [AdminController::class, 'dosenEdit'])->name('admin.dosen.edit');
        Route::put('data/dosen/{dosen}', [AdminController::class, 'dosenUpdate'])->name('admin.dosen.update');
        Route::delete('data/dosen/{dosen}', [AdminController::class, 'dosenDestroy'])->name('admin.dosen.destroy');

        // CRUD Data Mata Kuliah
        Route::get('data/matakuliah/create', [AdminController::class, 'mataKuliahCreate'])->name('admin.matakuliah.create');
        Route::get('data/matakuliah', [AdminController::class, 'mataKuliahIndex'])->name('admin.matakuliah.index');
        Route::post('data/matakuliah', [AdminController::class, 'mataKuliahStore'])->name('admin.matakuliah.store');
        Route::get('data/matakuliah/{matkul}/edit', [AdminController::class, 'mataKuliahEdit'])->name('admin.matakuliah.edit');
        Route::put('data/matakuliah/{matkul}', [AdminController::class, 'mataKuliahUpdate'])->name('admin.matakuliah.update');
        Route::delete('data/matakuliah/{matkul}', [AdminController::class, 'mataKuliahDestroy'])->name('admin.matakuliah.destroy');
    });


    // --- B. Rute Tenaga Pendidik (Tendik) - CREATE & SHOW ONLY ---
    Route::middleware([RoleMiddleware::class . ':tendik'])->prefix('tendik')->group(function () {
        
        // Dashboard Tendik
        Route::get('/dashboard', [TendikController::class, 'dashboard'])->name('tendik.dashboard');
        
        // Rekap Data
        Route::get('rekap', [TendikController::class, 'rekapData'])->name('tendik.rekap');
        
        // CRUD Data Dosen (CREATE, STORE, INDEX, SHOW ONLY)
        Route::get('data/dosen/create', [TendikController::class, 'dosenCreate'])->name('tendik.dosen.create');
        Route::get('data/dosen', [TendikController::class, 'dosenIndex'])->name('tendik.dosen.index');
        Route::post('data/dosen', [TendikController::class, 'dosenStore'])->name('tendik.dosen.store');
        Route::get('data/dosen/{dosen}', [TendikController::class, 'dosenShow'])->name('tendik.dosen.show'); 
        
        // HAPUS RUTE EDIT/UPDATE/DESTROY DOSEN

        // CRUD Mata Kuliah (CREATE, STORE, INDEX, SHOW ONLY)
        
        Route::get('data/matakuliah/create', [TendikController::class, 'matkulCreate'])->name('tendik.matakuliah.create'); 
        
        Route::post('data/matakuliah', [TendikController::class, 'matkulStore'])->name('tendik.matakuliah.store'); 
         
        Route::get('data/matakuliah', [TendikController::class, 'matkulIndex'])->name('tendik.matakuliah.index');
        
        Route::get('data/matakuliah/{matkul}', [TendikController::class, 'matkulShow'])->name('tendik.matakuliah.show'); 

    });
});