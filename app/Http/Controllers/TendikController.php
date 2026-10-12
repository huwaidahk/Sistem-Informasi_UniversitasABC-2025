<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Dosen; 
use App\Models\MataKuliah; 
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TendikController extends Controller
{
    // --- DASHBOARD TENDIK ---
    public function dashboard()
    {
        $userId = Auth::id();
        $dosenCount = Dosen::where('user_id', $userId)->count(); 
        $matkulCount = MataKuliah::where('user_id', $userId)->count();
        $profileCompletion = 75; 
        
        $inputDosenToday = Dosen::where('user_id', $userId)->whereDate('created_at', Carbon::today())->count();
        $inputMatkulToday = MataKuliah::where('user_id', $userId)->whereDate('created_at', Carbon::today())->count();

        // LOGIC AKTIVITAS TERAKHIR
        $latestDosen = Dosen::where('user_id', $userId)->latest('created_at')->first();
        $latestMatkul = MataKuliah::where('user_id', $userId)->latest('created_at')->first();
        $latestActivity = null; $latestTime = null;
        
        if ($latestDosen && (!$latestMatkul || $latestDosen->created_at > $latestMatkul->created_at)) {
            $latestActivity = 'Input Data Dosen';
            $latestTime = $latestDosen->created_at;
        } elseif ($latestMatkul) {
            $latestActivity = 'Input Data Mata Kuliah';
            $latestTime = $latestMatkul->created_at;
        }

        return view('tendik.dashboard', compact(
            'dosenCount', 'matkulCount', 'profileCompletion',
            'inputDosenToday', 'inputMatkulToday',
            'latestActivity', 'latestTime'
        ));
    }

    // --- REKAP DATA ---
    public function rekapData() 
    {
        $userId = Auth::id();
        $dosenRekap = Dosen::where('user_id', $userId)->get();
        // Mengubah 'dosen' menjadi 'dosens' (relasi Many-to-Many di Matkul)
        $matkulRekap = MataKuliah::where('user_id', $userId)->with('dosens')->get(); 
        return view('tendik.rekap', compact('dosenRekap', 'matkulRekap'));
    }

    // ----------------------------------------------------
    // --- CRUD DATA DOSEN OLEH TENDIK (CREATE & READ ONLY) ---
    // ----------------------------------------------------

    public function dosenIndex(Request $request) 
    {
        $userId = Auth::id();
        $keyword = $request->input('keyword'); 
        
        $dosens = Dosen::with(['user', 'mataKuliahs'])
                       ->where('user_id', $userId); // Hanya menampilkan inputan sendiri

        if ($keyword) {
            $dosens->where(function ($query) use ($keyword) {
                $query->where('nama_dosen', 'like', '%' . $keyword . '%')
                      ->orWhere('nidn', 'like', '%' . $keyword . '%');
            });
        }
        $dosens = $dosens->orderBy('nama_dosen')->get();
        
        return view('tendik.data.dosen.index', compact('dosens', 'keyword'));
    }

    public function dosenCreate() 
    {
        $mataKuliahs = MataKuliah::orderBy('nama_matkul')->get();
        return view('tendik.data.dosen.create', compact('mataKuliahs'));
    }

    public function dosenStore(Request $request) 
    {
        $request->validate([
            'nidn' => 'required|string|digits:10|unique:dosens,nidn',
            'nama_dosen' => 'required|string|max:255',
            'mata_kuliahs' => 'nullable|array', 
            'mata_kuliahs.*' => 'exists:mata_kuliahs,id', 
        ], [
            'nidn.required' => 'NIDN wajib diisi.',
            'nidn.digits' => 'NIDN harus tepat :digits karakter.',
            'nidn.unique' => 'NIDN ini sudah terdaftar.',
            'nama_dosen.required' => 'Nama dosen wajib diisi.',
        ]);

        $dosen = Dosen::create([
            'nidn' => $request->nidn,
            'nama_dosen' => $request->nama_dosen,
            'user_id' => Auth::id(), 
        ]);

        if ($request->has('mata_kuliahs')) {
            $dosen->mataKuliahs()->sync($request->mata_kuliahs);
        }

        return redirect()->route('tendik.dosen.index')->with('success', 'Data Dosen berhasil ditambahkan.');
    }
    
    // AKSES READ/SHOW DIBUKA
    public function dosenShow(Dosen $dosen) 
    {
        // Otorisasi: Hanya boleh melihat data yang diinputnya sendiri
        if ($dosen->user_id !== Auth::id()) { abort(403, 'Akses Ditolak.'); }
        
        $dosen->load('mataKuliahs', 'user'); 
        return view('tendik.data.dosen.show', compact('dosen'));
    }
    
    // Menonaktifkan Akses Edit Dosen
    public function dosenEdit(Dosen $dosen) 
    {
        abort(403, 'Akses Ditolak. Tendik hanya bisa menambah dan melihat data Dosen.'); 
    }

    // Menonaktifkan Akses Update Dosen
    public function dosenUpdate(Request $request, Dosen $dosen) 
    {
        abort(403, 'Akses Ditolak. Tendik hanya bisa menambah dan melihat data Dosen.'); 
    }

    // Menonaktifkan Akses Hapus Dosen
    public function dosenDestroy(Dosen $dosen) 
    {
        abort(403, 'Akses Ditolak. Tendik hanya bisa menambah dan melihat data Dosen.'); 
    }

    // -----------------------------------------------------------
    // --- CRUD DATA MATA KULIAH OLEH TENDIK (CREATE & READ ONLY) ---
    // -----------------------------------------------------------
    
    public function matkulIndex() 
    {
        $userId = Auth::id();
        $matkuls = MataKuliah::with(['dosens', 'user'])
                             ->where('user_id', $userId) // Hanya inputan sendiri
                             ->orderBy('nama_matkul')
                             ->get();
        
        return view('tendik.data.matakuliah.index', compact('matkuls'));
    }

    public function matkulCreate() 
    {
        $dosens = Dosen::orderBy('nama_dosen')->get();
        return view('tendik.data.matakuliah.create', compact('dosens'));
    }
    
    public function matkulStore(Request $request) 
    {
        $request->validate([
            'kode_matkul' => 'required|string|max:10|unique:mata_kuliahs,kode_matkul', 
            'nama_matkul' => 'required|string|max:255',
            'sks' => 'required|integer|min:1', 
            'dosens' => 'required|array', 
            'dosens.*' => 'exists:dosens,id',
        ]);

        $matkul = MataKuliah::create([
            'kode_matkul' => $request->kode_matkul,
            'nama_matkul' => $request->nama_matkul,
            'sks' => $request->sks, 
            'user_id' => Auth::id(), 
        ]);

        $matkul->dosens()->attach($request->dosens);

        return redirect()->route('tendik.matakuliah.index')->with('success', 'Data Mata Kuliah berhasil diinput.');
    }
    
    // AKSES READ/SHOW DIBUKA
    public function matkulShow(MataKuliah $matkul) 
    {
        // Otorisasi: Hanya boleh melihat data yang diinputnya sendiri
        if ($matkul->user_id !== Auth::id()) { abort(403, 'Akses Ditolak.'); }
        
        $matkul->load('dosens', 'user'); 
        return view('tendik.data.matakuliah.show', compact('matkul'));
    }
    
    // Menonaktifkan Akses Edit Mata Kuliah
    public function matkulEdit(MataKuliah $matkul) 
    {
        abort(403, 'Akses Ditolak. Tendik hanya bisa menambah dan melihat data Mata Kuliah.'); 
    }
    
    // Menonaktifkan Akses Update Mata Kuliah
    public function matkulUpdate(Request $request, MataKuliah $matkul) 
    {
        abort(403, 'Akses Ditolak. Tendik hanya bisa menambah dan melihat data Mata Kuliah.'); 
    }
    
    // Menonaktifkan Akses Hapus Mata Kuliah
    public function matkulDestroy(MataKuliah $matkul) 
    {
        abort(403, 'Akses Ditolak. Tendik hanya bisa menambah dan melihat data Mata Kuliah.'); 
    }
}