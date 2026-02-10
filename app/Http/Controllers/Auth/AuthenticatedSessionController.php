<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    // Display the login view.
    public function create(): View
    {
        return view('auth.login');
    }

    // Handle an incoming authentication request.
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();

        // Regenerate session to prevent fixation
        $request->session()->regenerate();

        // Ambil user yang login
        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang Admin!');
        }

        if ($user->role === 'petugas') {
            return redirect()->route('petugas.dashboard')
                ->with('success', 'Selamat datang Petugas!');
        }

        // default peminjam
        return redirect()->route('peminjam.dashboard')
            ->with('success', 'Selamat datang!');
    }

    // Destroy an authenticated session.
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Anda berhasil logout.');
    }
}
