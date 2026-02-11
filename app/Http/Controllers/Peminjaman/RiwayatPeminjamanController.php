<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Carbon\Carbon;

class RiwayatPeminjamanController extends Controller
{
    public function index()
    {
        // Ambil semua peminjaman milik user yang login
        $peminjamans = Peminjaman::where('nama_peminjam', auth()->user()->name)
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        // Hitung total denda user
        $totalDendaUser = $peminjamans->reduce(function($carry, $p) {
            if($p->tanggal_kembali) {
                $telat = Carbon::parse($p->tanggal_kembali)->gt(Carbon::parse($p->jatuh_tempo));
                if($telat) {
                    $hari = Carbon::parse($p->tanggal_kembali)->diffInDays(Carbon::parse($p->jatuh_tempo));
                    return $carry + ($hari * 10000);
                }
            }
            return $carry;
        }, 0);

        // Kirim ke view
        return view('peminjam.riwayat', compact('peminjamans', 'totalDendaUser'));
    }
}
