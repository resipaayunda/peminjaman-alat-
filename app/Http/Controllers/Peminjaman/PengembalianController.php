<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->tanggal_kembali) {
            return back()->with('error', 'Barang sudah dikembalikan');
        }

        // 🔥 UPDATE STATUS
        $peminjaman->update([
            'tanggal_kembali' => now(),
            'status' => 'Kembali'
        ]);

        // 🔥 BALIKIN STOK SESUAI JUMLAH
        $barang = Barang::where('nama_barang', $peminjaman->barang)->first();      
        if ($barang) {
            $barang->increment('stok', $peminjaman->jumlah);
        }

        return back()->with('success', 'Barang berhasil dikembalikan');
    }
}