<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RiwayatPeminjamanController extends Controller
{
    public function index()
    {
        // 🔥 HANYA DATA USER LOGIN
        $peminjamans = Peminjaman::where('user_id', Auth::id())
        ->orWhere('user_id', 0)
        ->get();

        $totalDendaUser = 0;

        foreach ($peminjamans as $p) {
            if ($p->tanggal_kembali) {
                $jatuhTempo = \Carbon\Carbon::parse($p->jatuh_tempo);
                $tglKembali = \Carbon\Carbon::parse($p->tanggal_kembali);

                if ($tglKembali->gt($jatuhTempo)) {
                    $hariTelat = $tglKembali->diffInDays($jatuhTempo);
                    $totalDendaUser += $hariTelat * 10000;
                }
            }
        }

        return view('peminjam.riwayat', compact('peminjamans', 'totalDendaUser'));
    }

    // halaman pengembalian (yang munculin data Rian di pengembalian)
    public function pengembalian()
    {
        $peminjamans = Peminjaman::where('user_id', Auth::id())
            ->whereNull('tanggal_kembali')
            ->get();

        return view('peminjam.pengembalian', compact('peminjamans'));
    }
}