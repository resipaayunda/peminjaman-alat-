<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\AdminActivity;
use App\Models\PetugasActivity;
use App\Models\PeminjamActivity;


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
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // ✅ LOG BERDASARKAN ROLE
        if ($user->role === 'admin') {
            AdminActivity::create([
                'admin_id' => $user->id,
                'action' => 'login',
                'model' => 'auth',
                'description' => $user->name . ' berhasil login ke sistem',
            ]);
        }

        if ($user->role === 'petugas') {
            PetugasActivity::create([
                'petugas_id' => $user->id,
                'action' => 'login',
                'model' => 'auth',
                'description' => $user->name . ' berhasil login ke sistem',
            ]);
        }

        if ($user->role === 'peminjam') {
            PeminjamActivity::create([
                'peminjam_id' => $user->id,
                'action' => 'login',
                'model' => 'auth',
                'description' => $user->name . ' berhasil login ke sistem',
            ]);
        }

        // Redirect
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang Admin!');
        }

        if ($user->role === 'petugas') {
            return redirect()->route('petugas.dashboard')
                ->with('success', 'Selamat datang Petugas!');
        }

        if ($user->role === 'peminjam') {
        return redirect()->route('peminjam.dashboard')
            ->with('success', 'Selamat datang!');
        }
    }


    // Destroy an authenticated session.
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {

            if ($user->role === 'admin') {
                AdminActivity::create([
                    'admin_id' => $user->id,
                    'action' => 'logout',
                    'model' => 'auth',
                    'description' => $user->name . ' logout dari sistem',
                ]);
            }

            if ($user->role === 'petugas') {
                PetugasActivity::create([
                    'petugas_id' => $user->id,
                    'action' => 'logout',
                    'model' => 'auth',
                    'description' => $user->name . ' logout dari sistem',
                ]);
            }

            if ($user->role === 'peminjam') {
                PeminjamActivity::create([
                    'peminjam_id' => $user->id,
                    'action' => 'logout',
                    'model' => 'auth',
                    'description' => $user->name . ' logout dari sistem',
                ]);
            }

        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Anda berhasil logout.');
    }
}
