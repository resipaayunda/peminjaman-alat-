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

    public function edit($id)
    {
        $pengembalian = Peminjaman::findOrFail($id);
        
        return view('admin.pengembalian-edit', compact('pengembalian'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal_kembali' => 'required|date',
            'kondisi_alat' => 'nullable|in:baik,rusak',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $pengembalian = Peminjaman::findOrFail($id);
            
            // Update data pengembalian
            $pengembalian->update([
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'kondisi_alat' => $validated['kondisi_alat'],
                'keterangan' => $validated['keterangan'] ?? null,
                'status' => 'dikembalikan'
            ]);

            return redirect()
                ->route('pengembalian.index')
                ->with('success', 'Data pengembalian berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal update pengembalian: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pengembalian = Peminjaman::findOrFail($id);
            
            // Ubah status kembali ke dipinjam
            $pengembalian->update([
                'status' => 'dipinjam',
                'tanggal_kembali' => null,
                'kondisi_alat' => null,
                'keterangan' => null,
            ]);

            return redirect()
                ->route('admin.pengembalian.index')
                ->with('success', 'Data pengembalian berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus pengembalian: ' . $e->getMessage());
        }
    }
}