<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        // Kalau bukan request AJAX, redirect ke halaman utama (bukan /login bawaan Laravel)
        return $request->expectsJson() ? null : '/welcome';
    }
}