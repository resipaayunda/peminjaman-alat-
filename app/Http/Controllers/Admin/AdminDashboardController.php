<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Ambil semua data
        $peminjamans = Peminjaman::latest()->get();

        // Total peminjaman
        $totalPeminjaman = Peminjaman::count();

        // Total pengembalian
        $totalPengembalian = Peminjaman::whereNotNull('tanggal_kembali')->count();

        //  TOTAL DENDA (KHUSUS YANG SUDAH DIKEMBALIKAN & TERLAMBAT)
        $totalDenda = 0;

        foreach ($peminjamans as $p) {
            if ($p->tanggal_kembali) {

                // cek apakah dia terlambat
                if ($p->tanggal_kembali > $p->jatuh_tempo) {

                    $hariTerlambat = Carbon::parse($p->jatuh_tempo)
                        ->diffInDays(Carbon::parse($p->tanggal_kembali));

                    $totalDenda += $hariTerlambat * 5000;
                }
            }
        }

        // Aktivitas (ambil semua)
        $recentPeminjaman = Peminjaman::latest()->get();

        return view('admin.dashboard', compact(
            'peminjamans',
            'totalPeminjaman',
            'totalPengembalian',
            'totalDenda',
            'recentPeminjaman'
        ));
    }
}