<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamDashboardController extends Controller
{
    public function index()
    {
        return view('peminjam.dashboard');
    }
}
