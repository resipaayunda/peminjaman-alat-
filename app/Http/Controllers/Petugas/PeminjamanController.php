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

    // ✅ ACC
    public function setujui($id)
    {
        $p = Peminjaman::findOrFail($id);

        $p->update([
            'status' => 'dipinjam'
        ]);

        return back()->with('success', 'Peminjaman disetujui');
    }

    // ❌ TOLAK
    public function tolak($id)
    {
        $p = Peminjaman::findOrFail($id);

        $p->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Peminjaman ditolak');
    }

    // 🔄 SELESAI
    public function kembali($id)
    {
        $p = Peminjaman::findOrFail($id);

        $p->update([
            'tanggal_kembali' => now(),
            'status' => 'selesai'
        ]);

        return back()->with('success', 'Pengembalian dikonfirmasi');
    }
}