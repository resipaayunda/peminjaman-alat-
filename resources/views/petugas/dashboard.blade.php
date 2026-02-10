@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Dashboard Petugas</h1>

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

    
</div>
@endsection
