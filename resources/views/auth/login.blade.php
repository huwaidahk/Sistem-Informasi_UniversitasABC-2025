<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Informasi Universitas ABC</title>
    @vite(['resources/sass/app.scss']) {{-- Memuat styling ungu-hitam --}}
    <style>
        body { 
            background-color: #1a033b; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 100vh; 
            margin: 0; 
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100 100"><rect width="100" height="100" fill="%231a033b"/><line x1="0" y1="10" x2="100" y2="10" stroke="%2331065f" stroke-width=".1"/><line x1="0" y1="20" x2="100" y2="20" stroke="%2331065f" stroke-width=".1"/><line x1="0" y1="30" x2="100" y2="30" stroke="%2331065f" stroke-width=".1"/><line x1="0" y1="40" x2="100" y2="40" stroke="%2331065f" stroke-width=".1"/><line x1="0" y1="50" x2="100" y2="50" stroke="%2331065f" stroke-width=".1"/><line x1="0" y1="60" x2="100" y2="60" stroke="%2331065f" stroke-width=".1"/><line x1="0" y1="70" x2="100" y2="70" stroke="%2331065f" stroke-width=".1"/><line x1="0" y1="80" x2="100" y2="80" stroke="%2331065f" stroke-width=".1"/><line x1="0" y1="90" x2="100" y2="90" stroke="%2331065f" stroke-width=".1"/><line x1="10" y1="0" x2="10" y2="100" stroke="%2331065f" stroke-width=".1"/><line x1="20" y1="0" x2="20" y2="100" stroke="%2331065f" stroke-width=".1"/><line x1="30" y1="0" x2="30" y2="100" stroke="%2331065f" stroke-width=".1"/><line x1="40" y1="0" x2="40" y2="100" stroke="%2331065f" stroke-width=".1"/><line x1="50" y1="0" x2="50" y2="100" stroke="%2331065f" stroke-width=".1"/><line x1="60" y1="0" x2="60" y2="100" stroke="%2331065f" stroke-width=".1"/><line x1="70" y1="0" x2="70" y2="100" stroke="%2331065f" stroke-width=".1"/><line x1="80" y1="0" x2="80" y2="100" stroke="%2331065f" stroke-width=".1"/><line x1="90" y1="0" x2="90" y2="100" stroke="%2331065f" stroke-width=".1"/></svg>'); 
            background-size: 100% 100%;
        }
        .login-box {
            max-width: 450px; 
            width: 100%; 
            padding: 50px 30px; 
            text-align: center;
        }
        .form-control-custom {
            background-color: rgba(49, 6, 95, 0.5); /* Warna input gelap transparan */
            border: 1px solid #6f42c1;
            color: white;
            padding: 15px 10px;
            margin-bottom: 20px;
        }
        .form-control-custom::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1 class="mb-5 fw-bold" style="color: white; font-size: 36px; text-shadow: 0 0 10px rgba(111, 66, 193, 0.5);">
            Sistem Informasi <br>Universitas ABC
        </h1>
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            {{-- Pesan Error / Success --}}
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            @error('email') <div class="alert alert-danger">{{ $message }}</div> @enderror

            <input type="email" name="email" class="form-control form-control-custom" 
                   placeholder="@universitasabc.ac.id" required value="{{ old('email') }}">
            
            <input type="password" name="password" class="form-control form-control-custom" 
                   placeholder="Password" required>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            
            <button type="submit" class="btn btn-purple w-100 py-3 fw-bold" style="font-size: 1.1em;">LOGIN</button>
        </form>
        
        <p class="mt-5 text-white-50">Belum mempunyai akun? 
            <a href="{{ route('register') }}" class="text-info text-decoration-none">Sign Up</a>
        </p>
    </div>
</body>
</html>