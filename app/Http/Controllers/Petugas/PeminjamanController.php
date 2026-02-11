<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::latest()->get();

        return view('petugas.peminjaman', compact('peminjamans'));
    }

    // TAMBAHAN WAJIB (ini yang bikin error kamu)
    public function kembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'tanggal_kembali' => now(),
            'status' => 'kembali'
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil dikonfirmasi');
    }
}
