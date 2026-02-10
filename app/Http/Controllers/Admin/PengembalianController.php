<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Peminjaman::where('status', '!=', 'dipinjam')
            ->orderBy('tanggal_kembali', 'desc')
            ->get();

        return view('admin.pengembalian', compact('pengembalians'));
    }
}
