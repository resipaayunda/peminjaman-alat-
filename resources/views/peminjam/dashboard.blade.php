@extends('layouts.peminjam')

@section('content')
@php
    use Carbon\Carbon;

    $totalDendaFix = 0;
@endphp

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Dashboard Peminjam</h1>

    {{-- HITUNG TOTAL DENDA --}}
    @foreach($peminjamans as $p)
        @php
            $jatuhTempo = Carbon::parse($p->jatuh_tempo)->startOfDay();
            $tglKembali = $p->tanggal_kembali 
                ? Carbon::parse($p->tanggal_kembali)->startOfDay() 
                : now()->startOfDay();

            $telat = $tglKembali->gt($jatuhTempo);

            $hariTelat = $telat 
                ? $jatuhTempo->diffInDays($tglKembali)
                : 0;

            $denda = $hariTelat * 5000;

            if($telat){
                $totalDendaFix += $denda;
            }
        @endphp
    @endforeach

    <div class="row g-4">

        {{-- Peminjaman --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body">
                    <div class="h4 fw-bold">
                        {{ $peminjamans->count() }}
                    </div>
                    <div class="text-muted small">Total Peminjaman</div>
                </div>
            </div>
        </div>

        {{-- Total Pengembalian --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body">
                    <div class="h4 fw-bold">
                        {{ $peminjamans->whereNotNull('tanggal_kembali')->count() }}
                    </div>
                    <div class="text-muted small">Total Pengembalian</div>
                </div>
            </div>
        </div>

        {{-- DENDA FIX --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body">
                    <div class="h4 fw-bold text-warning">
                        Rp {{ number_format($totalDendaFix, 0, ',', '.') }}
                    </div>
                    <div class="text-muted small">Total Denda</div>
                </div>
            </div>
        </div>

    </div>

    {{-- RIWAYAT SEMUA (BUKAN TERBARU) --}}
    {{-- RIWAYAT SEMUA --}}
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">

                <!-- HEADER JADI BIRU -->
                <div class="card-header bg-primary text-white fw-bold">
                    Riwayat Peminjaman
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama Barang</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Status</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($peminjamans as $p)
                                @php
                                    $jatuhTempo = Carbon::parse($p->jatuh_tempo)->startOfDay();
                                    $tglKembali = $p->tanggal_kembali 
                                        ? Carbon::parse($p->tanggal_kembali)->startOfDay() 
                                        : now()->startOfDay();

                                    $telat = $tglKembali->gt($jatuhTempo);

                                    $hariTelat = $telat 
                                        ? $jatuhTempo->diffInDays($tglKembali)
                                        : 0;

                                    $denda = $hariTelat * 5000;
                                @endphp

                                <tr>
                                    <td class="ps-4 fw-bold">{{ $p->barang }}</td>
                                    <td>{{ Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>

                                    <td>
                                        @if($p->tanggal_kembali)
                                            <span class="badge bg-success px-3">Selesai</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-3">Dipinjam</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($telat)
                                            <span class="text-danger fw-bold">
                                                Rp {{ number_format($denda, 0, ',', '.') }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Belum ada riwayat peminjaman
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection