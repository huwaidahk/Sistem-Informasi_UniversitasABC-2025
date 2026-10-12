<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\MataKuliah;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // --- DASHBOARD ---
    public function dashboard()
    {
        $today = MataKuliah::whereDate('created_at', Carbon::today())->count();
        $thisMonth = MataKuliah::whereMonth('created_at', Carbon::now()->month)->count();
        $thisYear = MataKuliah::whereYear('created_at', Carbon::now()->year)->count();
        $totalMatkulCount = MataKuliah::count();
        $tendikCount = User::where('role', 'tendik')->count();

        $latestDosen = Dosen::latest('created_at')->first();
        $latestMatkul = MataKuliah::latest('created_at')->first();
        
        $latestActivity = null;
        $latestTime = null;
        
        if ($latestDosen && (!$latestMatkul || $latestDosen->created_at > $latestMatkul->created_at)) {
            $latestActivity = 'Input Data Dosen';
            $latestTime = $latestDosen->created_at;
        } elseif ($latestMatkul) {
            $latestActivity = 'Input Data Mata Kuliah';
            $latestTime = $latestMatkul->created_at;
        }

        $chartData = ['hari' => $today, 'bulan' => $thisMonth, 'tahun' => $thisYear,];

        return view('admin.dashboard', compact('today', 'thisMonth', 'thisYear', 'chartData', 'tendikCount','totalMatkulCount', 'latestActivity', 'latestTime'));
    }
    
    // --- CRUD TENDIK (Tanpa Jabatan) ---
    
    public function index() // Menampilkan daftar Tendik
    {
        $tendiks = User::where('role', 'tendik')->orderBy('id')->get(); 
        return view('admin.tendik.index', compact('tendiks'));
    }
    public function create() { return view('admin.tendik.create'); }
    public function store(Request $request) 
    {
        $request->validate(['name' => 'required|string|max:255','email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'ends_with:@universitasabc.ac.id'],'password' => 'required|string|min:8|confirmed',]);
        User::create(['name' => $request->name,'email' => $request->email,'password' => Hash::make($request->password),'role' => 'tendik',]);
        return redirect()->route('admin.tendik.index')->with('success', 'Akun Tendik berhasil ditambahkan.');
    }
    public function edit(User $tendik) { if ($tendik->role !== 'tendik') { abort(404); } return view('admin.tendik.edit', compact('tendik')); }
    public function update(Request $request, User $tendik) 
    {
        $request->validate(['name' => 'required|string|max:255','email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($tendik->id), 'ends_with:@universitasabc.ac.id'],'password' => 'nullable|string|min:8|confirmed',]);
        $tendik->name = $request->name;
        $tendik->email = $request->email;
        if ($request->filled('password')) { $tendik->password = Hash::make($request->password); }
        $tendik->save();
        return redirect()->route('admin.tendik.index')->with('success', 'Akun Tendik berhasil diperbarui.');
    }
    public function destroy(User $tendik)
    {
        if ($tendik->role === 'administrator') { return back()->with('error', 'Tidak dapat menghapus Administrator utama.'); }
        $tendik->delete();
        return redirect()->route('admin.tendik.index')->with('success', 'Akun Tendik berhasil dihapus.');
    }
    
    // ----------------------------------------------------------------------
    // --- CRUD DATA DOSEN OLEH ADMIN (Mata Kuliah Dihapus dari form Dosen) ---
    // ----------------------------------------------------------------------
    
    public function dosenIndex()
    {
        // KOREKSI: HAPUS eager loading 'mataKuliahs'
        $dosens = Dosen::with(['user'])->orderBy('nama_dosen')->get(); 
        $tendiks = User::where('role', 'tendik')->get(); 
        return view('admin.data.dosen.index', compact('dosens', 'tendiks'));
    }

    public function dosenCreate() 
    {
        $tendiks = User::where('role', 'tendik')->get(); 
        // HAPUS: $mataKuliahs tidak lagi dimuat
        
        // Kirimkan hanya variabel yang dibutuhkan
        return view('admin.data.dosen.create', compact('tendiks'));
    }

    public function dosenStore(Request $request) 
    {
        $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nidn' => 'required|string|digits:10|unique:dosens,nidn',
            'user_id' => 'required|exists:users,id',
            // HAPUS VALIDASI MATAKULIAH
        ], [
            'nidn.required' => 'NIDN wajib diisi.',
            'nidn.digits' => 'NIDN harus tepat :digits karakter.', 
            'nidn.unique' => 'NIDN ini sudah terdaftar.',
            'nama_dosen.required' => 'Nama dosen wajib diisi.',
            'user_id.required' => 'Tendik Input wajib dipilih.',
        ]);

        $dosen = Dosen::create([
            'nama_dosen' => $request->nama_dosen,
            'nidn' => $request->nidn,
            'user_id' => $request->user_id,
        ]);
        
        // HAPUS LOGIC ATTACH MATAKULIAH

        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil ditambahkan.');
    }

    public function dosenEdit(Dosen $dosen) 
    {
        $tendiks = User::where('role', 'tendik')->get();
        // HAPUS: $mataKuliahs dan $dosenMataKuliahIds tidak lagi dimuat
        
        // Kirim hanya variabel yang dibutuhkan
        return view('admin.data.dosen.edit', compact('dosen', 'tendiks'));
    }

    public function dosenUpdate(Request $request, Dosen $dosen) 
    {
        $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nidn' => 'required|string|digits:10|unique:dosens,nidn,' . $dosen->id,
            'user_id' => 'required|exists:users,id',
            // HAPUS VALIDASI MATAKULIAH
        ], [
            'nidn.required' => 'NIDN wajib diisi.',
            'nidn.digits' => 'NIDN harus tepat :digits karakter.', 
            'nidn.unique' => 'NIDN ini sudah terdaftar.',
            'nama_dosen.required' => 'Nama dosen wajib diisi.',
            'user_id.required' => 'Tendik Input wajib dipilih.',
        ]);

        $dosen->update([
            'nama_dosen' => $request->nama_dosen,
            'nidn' => $request->nidn,
            'user_id' => $request->user_id,
        ]);
        
        // HAPUS LOGIC SYNC MATAKULIAH

        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil diperbarui.');
    }

    public function dosenDestroy(Dosen $dosen) 
    {
        // Memastikan detach Many-to-Many tetap berjalan jika ada relasi lama
        $dosen->mataKuliahs()->detach(); 
        $dosen->delete();
        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil dihapus.');
    }

    // ---------------------------------------------------------------------
    // --- CRUD DATA MATA KULIAH OLEH ADMIN (Sudah Benar, Menggunakan Plural) ---
    // ---------------------------------------------------------------------
    
    public function mataKuliahIndex() 
    {
        // Memastikan relasi 'dosens' (plural) dimuat
        $matkuls = MataKuliah::with('dosens')->orderBy('nama_matkul')->get(); 
        return view('admin.data.matakuliah.index', compact('matkuls')); 
    }

    public function mataKuliahCreate() 
    {
        // Mengambil semua Dosen untuk form select multiple
        $dosens = Dosen::orderBy('nama_dosen')->get();
        return view('admin.data.matakuliah.create', compact('dosens'));
    }

    public function mataKuliahStore(Request $request) 
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

        return redirect()->route('admin.matakuliah.index')->with('success', 'Data Mata Kuliah berhasil ditambahkan.');
    }

    public function mataKuliahEdit(MataKuliah $matkul) 
    {
        $dosens = Dosen::orderBy('nama_dosen')->get();
        $matkulDosenIds = $matkul->dosens->pluck('id')->toArray();
        
        return view('admin.data.matakuliah.edit', compact('matkul', 'dosens', 'matkulDosenIds'));
    }

    public function mataKuliahUpdate(Request $request, MataKuliah $matkul)
    {
        $request->validate([
            'kode_matkul' => ['required', 'string', 'max:10', Rule::unique('mata_kuliahs', 'kode_matkul')->ignore($matkul->id, 'id')],
            'nama_matkul' => 'required|string|max:255',
            'sks' => 'required|integer|min:1',
            'dosens' => 'required|array', 
            'dosens.*' => 'exists:dosens,id',
        ]);

        $matkul->update([
            'kode_matkul' => $request->kode_matkul,
            'nama_matkul' => $request->nama_matkul,
            'sks' => $request->sks,
        ]); 
        
        $matkul->dosens()->sync($request->dosens);
        
        return redirect()->route('admin.matakuliah.index')->with('success', 'Data Mata Kuliah berhasil diperbarui.');
    }

    public function mataKuliahDestroy(MataKuliah $matkul)
    {
        $matkul->dosens()->detach(); 
        $matkul->delete();
        return redirect()->route('admin.matakuliah.index')->with('success', 'Data Mata Kuliah berhasil dihapus.');
    }
}