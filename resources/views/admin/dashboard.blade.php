@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Dashboard Admin</h1>

    {{-- CARD --}}
    <div class="row g-4">
        {{-- Peminjaman --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs fw-bold text-primary">Peminjaman</div>
                            <div class="h4 fw-bold">{{ $totalPeminjaman }}</div>
                        </div>
                        <i class="fas fa-box fs-2 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pengembalian --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs fw-bold text-success">Pengembalian</div>
                            <div class="h4 fw-bold">{{ $totalPengembalian }}</div>
                        </div>
                        <i class="fas fa-check-circle fs-2 text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Denda --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs fw-bold text-warning">Denda</div>
                            <div class="h4 fw-bold">
                                Rp {{ number_format($totalDenda, 0, ',', '.') }}
                            </div>
                        </div>
                        <i class="fas fa-exclamation-triangle fs-2 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- AKTIVITAS TERAKHIR (INI AJA YANG DIPAKAI) --}}
    {{-- AKTIVITAS TERAKHIR --}}
    <div class="row mt-4">
        <div class="col-md-8"> {{-- INI YANG BIKIN LEBIH KECIL --}}
            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white fw-bold">
                    Aktivitas Terakhir
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Barang</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPeminjaman as $p)
                                <tr>
                                    <td>{{ $p->nama_peminjam }}</td>
                                    <td>{{ $p->barang }}</td>
                                    <td>
                                        @if($p->tanggal_kembali)
                                            <span class="badge bg-success">Kembali</span>
                                        @elseif($p->jatuh_tempo < now())
                                            <span class="badge bg-danger">Terlambat</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection