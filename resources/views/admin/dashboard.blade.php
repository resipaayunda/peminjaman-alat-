@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Dashboard</h1>

    {{-- Ringkasan Kartu --}}
    <div class="row g-4">
        {{-- Peminjaman --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Peminjaman
                            </div>
                            <div class="h4 fw-bold mb-0">
                                5
                            </div>
                        </div>
                        <i class="fas fa-box fs-2 text-primary opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Pengembalian --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                Total Pengembalian
                            </div>
                            <div class="h4 fw-bold mb-0">
                                10
                            </div>
                        </div>
                        <i class="fas fa-check-circle fs-2 text-success opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Denda --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                Denda
                            </div>
                            <div class="h4 fw-bold mb-0">
                                Rp 1.000
                            </div>
                        </div>
                        <i class="fas fa-exclamation-triangle fs-2 text-warning opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>  

    {{-- Aktivitas Terakhir --}}
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    Aktivitas Terakhir
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Barang</th>
                                <th>Status</th>
                                <th>Tgl</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPeminjaman as $p)
                                <tr>
                                    <td>{{ $p->nama_peminjam }}</td>
                                    <td>{{ $p->barang }}</td>
                                    <td>
                                        @if($p->tanggal_kembali)
                                            <span class="badge bg-success">Kembali</span>
                                        @else
                                            <span class="badge bg-warning">Dipinjam</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Peminjam --}}
    <div class="row mt-4">
        @if(isset($peminjamans) && $peminjamans->count())
            @foreach($peminjamans as $peminjaman)
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow h-100">
                        <div class="card-header bg-info text-white fw-bold">
                            Peminjam
                        </div>
                        <div class="card-body">
                            <p><strong>Nama:</strong> {{ $peminjaman->nama_peminjam }}</p>
                            <p><strong>Barang:</strong> {{ $peminjaman->barang }}</p>
                            <p><strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</p>
                            <p><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($peminjaman->jatuh_tempo)->format('d M Y') }}</p>
                            <p>
                                <strong>Status:</strong>
                                @if($peminjaman->status == 'dipinjam')
                                    <span class="badge bg-primary">Dipinjam</span>
                                @elseif($peminjaman->status == 'terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @elseif($peminjaman->status == 'kembali')
                                    <span class="badge bg-success">Kembali</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
