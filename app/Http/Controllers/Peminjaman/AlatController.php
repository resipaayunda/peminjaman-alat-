<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = \App\Models\Kategori::all();
        $query = Barang::query();

        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $alats = $query->get();
        return view('peminjam.alat', compact('alats', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required',
            'jatuh_tempo' => 'required'
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        $barang->decrement('stok', $request->jumlah);

        Peminjaman::create([
            'user_id' => Auth::id(), // ✅ pastikan user login
            'nama_peminjam' => Auth::user()->name,
            'barang' => $barang->nama_barang,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'jatuh_tempo' => $request->jatuh_tempo,
            'status' => 'Dipinjam'
        ]);

        return back()->with('success', 'Pengajuan berhasil dikirim');
    }
}