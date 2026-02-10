<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PetugasDashboardController extends Controller
{
    public function index()
    {
        // Ambil 5 aktivitas terakhir
        $recentPeminjaman = Peminjaman::latest()->take(5)->get();

        // Ambil semua data peminjaman
        $peminjamans = Peminjaman::latest()->get();

        return view('petugas.dashboard', compact(
            'recentPeminjaman',
            'peminjamans'
        ));
    }
}
