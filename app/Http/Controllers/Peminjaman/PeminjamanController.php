<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'nama_peminjam' => 'required',
            'tanggal_pinjam' => 'required|date',
            'jatuh_tempo' => 'required|date'
        ]);

        //  AMBIL DATA BARANG
        $barang = Barang::findOrFail($request->barang_id);

        //  CEK STOK
        if ($barang->stok <= 0) {
            return back()->with('error', 'Stok barang habis!');
        }

        //  SIMPAN PEMINJAMAN
        Peminjaman::create([
            'nama_peminjam' => $request->nama_peminjam,
            'barang' => $barang->nama_barang, // tetap pakai ini sesuai sistem kamu
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'jatuh_tempo' => $request->jatuh_tempo,
            'status' => 'Dipinjam'
        ]);

        //  KURANGI STOK
        $barang->stok = $barang->stok - 1;
        $barang->save();

        return back()->with('success', 'Pengajuan berhasil, stok berkurang!');
    }
}