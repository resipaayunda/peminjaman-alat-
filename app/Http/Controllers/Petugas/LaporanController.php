<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'barang'])->latest();

        // FILTER
        if ($request->filter && $request->tanggal) {

            if ($request->filter == 'hari') {
                $query->whereDate('tanggal_pinjam', $request->tanggal);
            }

            elseif ($request->filter == 'minggu' || $request->filter == 'bulan') {

                $start = Carbon::parse($request->tanggal)->startOfDay();
                $end = $request->tanggal_sampai 
                        ? Carbon::parse($request->tanggal_sampai)->endOfDay()
                        : $start;

                $query->whereBetween('tanggal_pinjam', [$start, $end]);
            }
        }

        $laporans = $query->get();

        return view('petugas.laporan', compact('laporans'));
    }

    public function exportPdf(Request $request)
    {
        $query = Peminjaman::with(['user', 'barang'])->latest();

        // FILTER (BIAR PDF IKUT KEFILTER)
        if ($request->filter && $request->tanggal) {

            if ($request->filter == 'hari') {
                $query->whereDate('tanggal_pinjam', $request->tanggal);
            }

            elseif ($request->filter == 'minggu' || $request->filter == 'bulan') {

                $start = Carbon::parse($request->tanggal)->startOfDay();
                $end = $request->tanggal_sampai 
                        ? Carbon::parse($request->tanggal_sampai)->endOfDay()
                        : $start;

                $query->whereBetween('tanggal_pinjam', [$start, $end]);
            }
        }

        $laporans = $query->get();

        $pdf = Pdf::loadView('petugas.laporan_pdf', compact('laporans'));

        return $pdf->download('laporan-peminjaman.pdf');
    }
}