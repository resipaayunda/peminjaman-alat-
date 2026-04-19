<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamDashboardController extends Controller
{
    public function index()
    {
        // Ambil semua data (BIAR AMAN)
        $peminjamans = Peminjaman::with('barang')->latest()->get();

        // Total dipinjam (yang belum kembali)
        $totalDipinjam = $peminjamans->whereNull('tanggal_kembali')->count();

        // Total kembali
        $totalKembali = $peminjamans->whereNotNull('tanggal_kembali')->count();

        // HITUNG DENDA (fix biar sesuai)
        $totalDenda = 0;

        foreach ($peminjamans as $p) {
            $jatuhTempo = Carbon::parse($p->jatuh_tempo)->startOfDay();

            $tglKembali = $p->tanggal_kembali
                ? Carbon::parse($p->tanggal_kembali)->startOfDay()
                : now()->startOfDay();

            if ($tglKembali->gt($jatuhTempo)) {
                $hariTelat = $jatuhTempo->diffInDays($tglKembali);
                $totalDenda += $hariTelat * 5000;
            }
        }

        return view('peminjam.dashboard', compact(
            'peminjamans',
            'totalDipinjam',
            'totalKembali',
            'totalDenda'
        ));
    }
}