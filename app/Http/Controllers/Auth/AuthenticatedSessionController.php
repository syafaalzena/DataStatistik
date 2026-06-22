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
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => ['required'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        if (auth()->user()->role == 'admin') {
            return redirect('/dashboard');
        }

        return redirect('/dashboard');
    }

     return back()->withErrors([
        'username' => 'Username atau password salah.',
    ])->onlyInput('username');
}

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255', 'unique:users'],
        'nip' => ['required', 'string', 'max:18', 'unique:users'],
        'email' => ['required', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Password::min(8)],
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'username' => $validated['username'],
        'nip' => $validated['nip'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'user',
    ]);

    Auth::login($user);

    return redirect('/dashboard');
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
