<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanExport implements FromCollection
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Peminjaman::with(['user', 'barang']);

        //  FILTER
        if ($this->request->filter && $this->request->tanggal) {

            if ($this->request->filter == 'hari') {
                $query->whereDate('tanggal_pinjam', $this->request->tanggal);
            }

            elseif ($this->request->filter == 'minggu') {
                $start = Carbon::parse($this->request->tanggal)->startOfWeek();
                $end = Carbon::parse($this->request->tanggal)->endOfWeek();

                $query->whereBetween('tanggal_pinjam', [$start, $end]);
            }

            elseif ($this->request->filter == 'bulan') {
                $query->whereMonth('tanggal_pinjam', Carbon::parse($this->request->tanggal)->month)
                      ->whereYear('tanggal_pinjam', Carbon::parse($this->request->tanggal)->year);
            }
        }

        return $query->get();
    }
}