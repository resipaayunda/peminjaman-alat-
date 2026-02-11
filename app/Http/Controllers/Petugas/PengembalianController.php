<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PengembalianController extends Controller
{
     public function index()
    {
        $pengembalians = Peminjaman::whereNotNull('tanggal_kembali')
            ->latest()
            ->get();

        return view('petugas.pengembalian', compact('pengembalians'));
    }
}
