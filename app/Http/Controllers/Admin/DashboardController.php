<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::latest()->get(); // ambil semua data peminjaman
        return view('admin.dashboard', compact('peminjamans'));
    }
}
