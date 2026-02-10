<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::latest()->get(); // ambil semua
        return view('admin.peminjaman', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required',
            'barang' => 'required',
            'tanggal_pinjam' => 'required|date',
            'jatuh_tempo' => 'required|date',
        ]);

        Peminjaman::create([ 
            'nama_peminjam' => $request->nama_peminjam,
            'barang' => $request->barang,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'jatuh_tempo' => $request->jatuh_tempo,
            'status' => 'dipinjam',
        ]);

        return redirect()->route('admin.peminjaman.index')
                         ->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    /**
     * =========================
     * ✏️ EDIT DATA PEMINJAMAN
     * =========================
     */
    if ($request->has('nama_peminjam')) {

        $request->validate([
            'nama_peminjam'   => 'required',
            'barang'          => 'required',
            'tanggal_pinjam'  => 'required|date',
            'jatuh_tempo'     => 'required|date',
        ]);

        $peminjaman->update([
            'nama_peminjam'  => $request->nama_peminjam,
            'barang'         => $request->barang,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'jatuh_tempo'    => $request->jatuh_tempo,
        ]);

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    /**
     * =========================
     * ✔️ PROSES PENGEMBALIAN
     * =========================
     */
    $tanggalKembali = Carbon::today();
    $jatuhTempo = Carbon::parse($peminjaman->jatuh_tempo);

    $peminjaman->tanggal_kembali = $tanggalKembali;

    if ($tanggalKembali->gt($jatuhTempo)) {
        $peminjaman->status = 'terlambat';
    } else {
        $peminjaman->status = 'kembali';
    }

    $peminjaman->save();

    return redirect()
        ->route('admin.peminjaman.index')
        ->with('success', 'Barang berhasil dikembalikan!');
}



    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
                         ->with('success', 'Peminjaman berhasil dihapus!');
    }
}
