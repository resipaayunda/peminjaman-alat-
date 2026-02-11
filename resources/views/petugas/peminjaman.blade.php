@extends('layouts.petugas') {{-- Pastikan layoutnya benar --}}

@section('content')
@php
    use Carbon\Carbon;
    $today = Carbon::today();
@endphp

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3 fw-bold text-gray-800 mb-1">Verifikasi Peminjaman</h1>
            <p class="text-muted small mb-0">Kelola pengembalian barang secara real-time.</p>
        </div>
        {{-- Petugas tidak punya tombol "Tambah" --}}
    </div>

    {{-- STATISTIK SINGKAT --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm border-start border-primary border-4">
                <div class="card-body py-3">
                    <div class="small text-muted fw-bold text-uppercase">Perlu Kembali</div>
                    <div class="h4 mb-0 fw-bold">{{ $peminjamans->whereNull('tanggal_kembali')->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm border-start border-danger border-4">
                <div class="card-body py-3">
                    <div class="small text-muted fw-bold text-uppercase">Terlambat</div>
                    <div class="h4 mb-0 fw-bold text-danger">
                        {{ $peminjamans->filter(fn($p) => is_null($p->tanggal_kembali) && Carbon::parse($p->jatuh_tempo)->lt($today))->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL OPERASIONAL --}}
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary"><i class="fas fa-list me-2"></i>Daftar Aktivitas Pinjam</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small text-muted text-uppercase">
                            <th class="ps-4">Peminjam</th>
                            <th>Barang</th>
                            <th>Batas Waktu</th>
                            <th>Status</th>
                            <th class="text-center">Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $p)
                        @php
                            $jatuhTempo = Carbon::parse($p->jatuh_tempo);
                            $terlambat = is_null($p->tanggal_kembali) && $jatuhTempo->lt($today);
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $p->nama_peminjam }}</div>
                                <small class="text-muted">Tgl Pinjam: {{ Carbon::parse($p->tanggal_pinjam)->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $p->barang }}</div>
                            </td>
                            <td>
                                <div class="{{ $terlambat ? 'text-danger fw-bold' : '' }}">
                                    {{ $jatuhTempo->format('d M Y') }}
                                </div>
                            </td>
                            <td>
                                @if ($p->tanggal_kembali)
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3">Sudah Kembali</span>
                                @elseif ($terlambat)
                                    <span class="badge rounded-pill bg-danger text-white px-3 shadow-sm">🔴 Terlambat</span>
                                @else
                                    <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-3">Dipinjam</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (is_null($p->tanggal_kembali))
                                    {{-- Hanya tombol konfirmasi kembali --}}
                                    <form action="{{ route('petugas.peminjaman.kembali', $p->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm px-3 shadow-sm" 
                                                onclick="return confirm('Konfirmasi pengembalian barang ini?')">
                                            <i class="fas fa-check-circle me-1"></i> Selesai
                                        </button>
                                    </form>
                                @else
                                    <i class="fas fa-check-double text-success" title="Sudah diverifikasi"></i>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Tidak ada aktivitas peminjaman hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Warna Badge Soft agar senada dengan tema putih */
    .bg-success-subtle { background-color: rgba(25, 135, 84, 0.1) !important; }
    .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.1) !important; }
    .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.1) !important; }
</style>
@endsection