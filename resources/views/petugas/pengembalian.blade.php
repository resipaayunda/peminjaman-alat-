@extends('layouts.petugas') {{-- Menggunakan layout petugas --}}

@section('content')
@php
    use Carbon\Carbon;
@endphp

<div class="container-fluid px-4">
    <div class="mt-4 mb-4">
        <h1 class="h3 fw-bold text-gray-800">Riwayat Pengembalian</h1>
        <p class="text-muted small">Daftar barang yang sudah berhasil dikembalikan ke gudang.</p>
    </div>

    {{-- STATISTIK RINGKAS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm border-start border-success border-4">
                <div class="card-body py-3">
                    <div class="small text-muted fw-bold text-uppercase">Total Selesai</div>
                    <div class="h4 mb-0 fw-bold text-success">{{ $pengembalians->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm border-start border-warning border-4">
                <div class="card-body py-3">
                    <div class="small text-muted fw-bold text-uppercase">Total Denda Terkumpul</div>
                    <div class="h4 mb-0 fw-bold text-dark">
                        @php
                            $totalDenda = $pengembalians->reduce(function($carry, $p) {
                                $telat = Carbon::parse($p->tanggal_kembali)->gt(Carbon::parse($p->jatuh_tempo));
                                if($telat) {
                                    $hari = Carbon::parse($p->tanggal_kembali)->diffInDays(Carbon::parse($p->jatuh_tempo));
                                    return $carry + ($hari * 10000);
                                }
                                return $carry;
                            }, 0);
                        @endphp
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL MONITORING --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small text-muted text-uppercase fw-bold">
                            <th class="ps-4 py-3">Peminjam</th>
                            <th>Barang</th>
                            <th>Jatuh Tempo</th>
                            <th>Tgl Kembali</th>
                            <th>Kondisi Status</th>
                            <th class="text-end pe-4">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengembalians as $p)
                        @php
                            $jatuhTempo = Carbon::parse($p->jatuh_tempo);
                            $tanggalKembali = Carbon::parse($p->tanggal_kembali);
                            $telat = $tanggalKembali->gt($jatuhTempo);
                            $hariTelat = $telat ? $tanggalKembali->diffInDays($jatuhTempo) : 0;
                            $denda = $hariTelat * 10000;
                        @endphp
                        <tr>
                            <td class="ps-4 py-3">
                                <span class="fw-bold text-dark">{{ $p->nama_peminjam }}</span>
                            </td>
                            <td>{{ $p->barang }}</td>
                            <td class="small text-muted">{{ $jatuhTempo->format('d M Y') }}</td>
                            <td class="fw-bold text-primary">{{ $tanggalKembali->format('d M Y') }}</td>
                            <td>
                                @if ($telat)
                                    <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3">Terlambat {{ $hariTelat }} Hari</span>
                                @else
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3">Tepat Waktu</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if ($telat)
                                    <span class="text-danger fw-bold">Rp {{ number_format($denda, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-history fa-2x mb-3 d-block opacity-25"></i>
                                Belum ada riwayat pengembalian.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Menggunakan skema warna soft agar enak dilihat */
    .bg-success-subtle { background-color: rgba(25, 135, 84, 0.1) !important; }
    .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.1) !important; }
    .table-hover tbody tr:hover { background-color: #fcfdfe; }
</style>
@endsection