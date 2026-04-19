@extends('layouts.peminjam')

@section('content')
@php
    use Carbon\Carbon;

    $totalDenda = 0;
@endphp

<div class="container-fluid px-4">
    <div class="mt-4 mb-4">
        <h1 class="h3 fw-bold text-dark">Riwayat Peminjaman Saya</h1>
        <p class="text-muted small">Pantau status alat yang Anda pinjam.</p>
    </div>

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
                $totalDenda += $denda;
            }
        @endphp
    @endforeach

    {{-- RINGKASAN --}}
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body">
                    <div class="h4 fw-bold">
                        {{ $peminjamans->whereNull('tanggal_kembali')->count() }}
                    </div>
                    <div class="small text-muted">Sedang Dipinjam</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body">
                    <div class="h4 fw-bold">
                        {{ $peminjamans->whereNotNull('tanggal_kembali')->count() }}
                    </div>
                    <div class="small text-muted">Sudah Kembali</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body">
                    <div class="h4 fw-bold text-warning">
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </div>
                    <div class="small text-muted">Total Denda</div>
                </div>
            </div>
        </div>

    </div>

    {{-- TABEL --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th> {{-- 🔥 TAMBAHAN --}}
                            <th>Barang</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Tgl Kembali</th>
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
                            <td>{{ $loop->iteration }}</td> {{-- 🔥 AUTO NOMOR --}}
                            <td>{{ $p->barang }}</td>
                            <td>{{ Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                            <td>{{ $jatuhTempo->format('d M Y') }}</td>

                            <td>
                                @if($p->tanggal_kembali)
                                    {{ Carbon::parse($p->tanggal_kembali)->format('d M Y') }}
                                @else
                                    <span class="text-muted">Belum</span>
                                @endif
                            </td>

                            <td>
                                @if($p->tanggal_kembali)
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning">Dipinjam</span>
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
                            <td colspan="7" class="text-center py-4 text-muted">
                                Belum ada riwayat
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection