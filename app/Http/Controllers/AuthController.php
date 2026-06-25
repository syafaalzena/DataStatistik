<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('welcome');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Cek apakah username terdaftar
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()
                ->withErrors(['username' => 'Akun tidak terdaftar. Silakan daftar terlebih dahulu.'])
                ->withInput();
        }

        // Username ada tapi password salah
        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->boolean('remember'))) {
            return back()
                ->withErrors(['password' => 'Password yang Anda masukkan salah.'])
                ->withInput();
        }

        $request->session()->regenerate();
        return redirect()->route('statistik.index');
    }

    public function showRegister()
    {
        return view('welcome');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'nip'      => ['required', 'string', 'max:18', 'unique:users'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'username.unique' => 'Username sudah digunakan, coba username lain.',
            'nip.unique'      => 'NIP ini sudah terdaftar, gunakan NIP lain.',
            'email.unique'    => 'Email sudah terdaftar dengan akun lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'    => 'Password minimal 8 karakter.',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'nip'      => $request->nip,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/')->with('success', 'Registrasi berhasil. Silakan login dengan akun Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}