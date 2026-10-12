<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // Import Class Rule
use App\Models\User;

class AuthController extends Controller
{
    // --- 1. Login ---

    public function showLoginForm() 
    {
        return view('auth.login');
    }

    public function login(Request $request) 
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'password.min' => 'Password minimal 8 karakter.',
            // ... (Pesan lainnya)
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userRole = strtolower(Auth::user()->role); 

            if ($userRole == 'administrator') {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/tendik/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau Password salah.',
        ])->onlyInput('email');
    }

    // --- 2. Register / Sign Up ---

    public function showRegisterForm() 
    {
        return view('auth.register');
    }

    public function register(Request $request) 
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:administrator,tendik', 
            
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'), 
                
                // KOREKSI UTAMA: Menghapus Rule::when() dan menerapkan satu domain
                'ends_with:@universitasabc.ac.id', // Admin DAN Tendik HARUS menggunakan domain ini
            ], [
                // Pesan untuk Nama
                'nama_lengkap.required' => 'Nama Lengkap wajib diisi.',

                // Pesan untuk Password
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',

                // Pesan untuk Email
                'email.required' => 'Email wajib diisi.',
                'email.unique' => 'Email ini sudah terdaftar.',
                'email.ends_with' => 'Email harus menggunakan domain yang sesuai dengan Role yang dipilih.',
            ]
        ]);

        User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => strtolower($request->role), 
        ]);

        return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    // --- 3. Logout ---

    public function logout(Request $request) 
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}