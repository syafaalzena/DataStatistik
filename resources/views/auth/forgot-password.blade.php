<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SIDKP</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #fffcf3ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .forgot-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        }
        .forgot-card h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
        }
        .btn-dark-custom {
            background-color: #0f1b35;
            color: #fff;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        .btn-dark-custom:hover { background-color: #1a2947; color: #fff; }
    </style>
</head>
<body>
    <div class="forgot-card">
        <h2 class="mb-3">Lupa Password</h2>
        <p style="color:#64748b;font-size:0.9rem;" class="mb-4">
            Masukkan email akun Anda. Kami akan mengirimkan tautan untuk membuat password baru.
        </p>

        {{-- Breeze session status (link berhasil dikirim) --}}
        @if (session('status'))
            <div class="alert alert-success" style="font-size:0.9rem;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="example@gmail.com" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-dark-custom px-4 w-100 mb-3">Kirim Link Reset</button>

            <div class="text-center">
                <a href="{{ url('/') }}" style="color:#64748b;font-size:0.9rem;text-decoration:none;">
                    Kembali ke Halaman Login
                </a>
            </div>
        </form>
    </div>
</body>
</html>