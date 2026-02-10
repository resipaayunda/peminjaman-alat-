<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Total peminjaman aktif (belum dikembalikan)
        $totalPeminjaman = Peminjaman::whereNull('tanggal_kembali')->count();

        // Total pengembalian
        $totalPengembalian = Peminjaman::whereNotNull('tanggal_kembali')->count();

        // Total denda (contoh: 1000 / hari telat)
        $totalDenda = Peminjaman::whereNotNull('tanggal_kembali')
            ->whereColumn('tanggal_kembali', '>', 'jatuh_tempo')
            ->get()
            ->sum(function ($p) {
                $hariTelat = Carbon::parse($p->tanggal_kembali)
                    ->diffInDays(Carbon::parse($p->jatuh_tempo));
                return $hariTelat * 1000;
            });

        // DATA TERAKHIR (BIAR GA RAMAI)
        $recentPeminjaman = Peminjaman::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPeminjaman',
            'totalPengembalian',
            'totalDenda',
            'recentPeminjaman'
        ));
    }
}
