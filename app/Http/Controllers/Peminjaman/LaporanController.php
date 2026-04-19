<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::latest();

        if ($request->filter && $request->tanggal) {

            if ($request->filter == 'hari') {
                $query->whereDate('tanggal_pinjam', $request->tanggal);
            }

            // 🔥 TAMBAHAN RANGE
            elseif ($request->filter == 'minggu' || $request->filter == 'bulan') {

                $start = Carbon::parse($request->tanggal)->startOfDay();
                $end = $request->tanggal_sampai 
                        ? Carbon::parse($request->tanggal_sampai)->endOfDay()
                        : $start;

                $query->whereBetween('tanggal_pinjam', [$start, $end]);
            }
        }

        $laporans = $query->get();

        return view('peminjam.laporan', compact('laporans'));
    }

    public function exportPdf(Request $request)
    {
        $query = Peminjaman::latest();

        if ($request->filter && $request->tanggal) {

            if ($request->filter == 'hari') {
                $query->whereDate('tanggal_pinjam', $request->tanggal);
            }

            // 🔥 TAMBAHAN RANGE (PDF JUGA)
            elseif ($request->filter == 'minggu' || $request->filter == 'bulan') {

                $start = Carbon::parse($request->tanggal)->startOfDay();
                $end = $request->tanggal_sampai 
                        ? Carbon::parse($request->tanggal_sampai)->endOfDay()
                        : $start;

                $query->whereBetween('tanggal_pinjam', [$start, $end]);
            }
        }

        $laporans = $query->get();

        $pdf = Pdf::loadView('peminjam.laporan_pdf', compact('laporans'));

        return $pdf->download('laporan_peminjaman_saya.pdf');
    }
}