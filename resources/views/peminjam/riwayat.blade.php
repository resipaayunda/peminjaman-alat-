@extends('layouts.peminjam')

@section('content')
@php
    use Carbon\Carbon;
@endphp

<div class="container-fluid px-4">
    <div class="mt-4 mb-4">
        <h1 class="h3 fw-bold text-dark">Riwayat Peminjaman Saya</h1>
        <p class="text-muted small">Pantau status alat yang Anda pinjam dan riwayat pengembaliannya.</p>
    </div>

    {{-- KARTU RINGKASAN --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body py-3">
                    <div class="small fw-bold text-uppercase opacity-75">Sedang Dipinjam</div>
                    <div class="h4 mb-0 fw-bold">{{ $peminjamans->where('status', 'Dipinjam')->count() }} Alat</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-success border-4">
                <div class="card-body py-3">
                    <div class="small text-muted fw-bold text-uppercase">Sudah Kembali</div>
                    <div class="h4 mb-0 fw-bold text-success">{{ $peminjamans->where('status', 'Kembali')->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-danger border-4">
                <div class="card-body py-3">
                    <div class="small text-muted fw-bold text-uppercase">Total Denda Saya</div>
                    <div class="h4 mb-0 fw-bold text-danger">
                        Rp {{ number_format($totalDendaUser, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL RIWAYAT --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small text-muted text-uppercase fw-bold">
                            <th class="ps-4 py-3">Informasi Alat</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $p)
                        @php
                            $jatuhTempo = Carbon::parse($p->jatuh_tempo);
                            $tglKembali = $p->tanggal_kembali ? Carbon::parse($p->tanggal_kembali) : null;
                            $telat = $tglKembali ? $tglKembali->gt($jatuhTempo) : Carbon::now()->gt($jatuhTempo);
                            $hariTelat = $tglKembali ? $tglKembali->diffInDays($jatuhTempo) : Carbon::now()->diffInDays($jatuhTempo);
                        @endphp
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $p->barang }}</div>
                                <small class="text-muted">Keperluan: {{ $p->keperluan }}</small>
                            </td>
                            <td>{{ Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                            <td>{{ $jatuhTempo->format('d M Y') }}</td>
                            <td>
                                @if($tglKembali)
                                    <span class="text-primary fw-bold">{{ $tglKembali->format('d M Y') }}</span>
                                @else
                                    <span class="text-muted italic small">Belum Kembali</span>
                                @endif
                            </td>
                            <td>
                                @if($p->status == 'Kembali')
                                    @if($tglKembali && $tglKembali->gt($jatuhTempo))
                                        <span class="badge rounded-pill bg-danger-subtle text-danger px-3 border border-danger-subtle">Selesai (Telat)</span>
                                    @else
                                        <span class="badge rounded-pill bg-success-subtle text-success px-3 border border-success-subtle">Selesai</span>
                                    @endif
                                @else
                                    @if(Carbon::now()->gt($jatuhTempo))
                                        <span class="badge rounded-pill bg-danger text-white px-3 shadow-sm">Terlambat!</span>
                                    @else
                                        <span class="badge rounded-pill bg-warning-subtle text-warning px-3 border border-warning-subtle text-dark">Sedang Dipinjam</span>
                                    @endif
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($p->status == 'Kembali' && $tglKembali && $tglKembali->gt($jatuhTempo))
                                    <span class="text-danger fw-bold">Rp {{ number_format($hariTelat * 10000, 0, ',', '.') }}</span>
                                @elseif($p->status == 'Dipinjam' && Carbon::now()->gt($jatuhTempo))
                                    <span class="text-danger small italic">Berjalan: Rp {{ number_format($hariTelat * 10000, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-2x mb-3 d-block opacity-25"></i>
                                Anda belum pernah meminjam alat.
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
    .bg-success-subtle { background-color: rgba(25, 135, 84, 0.1) !important; }
    .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.1) !important; }
    .bg-warning-subtle { background-color: rgba(255, 193, 7, 0.1) !important; }
    .table-hover tbody tr:hover { background-color: #fcfdfe; }
</style>
@endsection
