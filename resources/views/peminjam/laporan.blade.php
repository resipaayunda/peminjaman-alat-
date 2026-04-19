@extends('layouts.peminjam')

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="h3">Laporan Peminjaman Saya</h1>

        <div class="text-end">
            <!-- TAMBAHAN -->
            <div class="small text-muted mb-1">Cetak Laporan</div>

            <a href="{{ route('peminjam.laporan.pdf', request()->all()) }}" 
               class="btn btn-outline-danger btn-sm">
                <i class="fas fa-file-pdf me-1"></i> PDF
            </a>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card mb-3 shadow-sm filter-card">
        <div class="card-body">
            <form method="GET" action="">
                <div class="row g-2 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label small">Filter</label>
                        <select name="filter" class="form-select filter-input">
                            <option value="">-- Pilih --</option>
                            <option value="hari" {{ request('filter')=='hari' ? 'selected' : '' }}>Per Hari</option>
                            <option value="minggu" {{ request('filter')=='minggu' ? 'selected' : '' }}>Per Minggu</option>
                            <option value="bulan" {{ request('filter')=='bulan' ? 'selected' : '' }}>Per Bulan</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small">Dari Tanggal</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control filter-input">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small">Sampai Tanggal</label>
                        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="form-control filter-input">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary btn-sm w-100">Filter</button>
                    </div>

                    <div class="col-md-1">
                        <a href="{{ route('peminjam.laporan.index') }}" class="btn btn-secondary btn-sm w-100">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead class="table-warning text-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pinjam</th>
                        <th>Barang</th>
                        <th>Jatuh Tempo</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($laporans as $i => $l)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $l->tanggal_pinjam }}</td>
                        <td>{{ $l->barang }}</td>
                        <td>{{ $l->jatuh_tempo }}</td>
                        <td>{{ $l->tanggal_kembali ?? '-' }}</td>

                        <td>
                            @php
                                if ($l->tanggal_kembali) {
                                    $status = 'Selesai';
                                    $warna = 'success';
                                } elseif (now()->gt($l->jatuh_tempo)) {
                                    $status = 'Terlambat';
                                    $warna = 'danger';
                                } else {
                                    $status = 'Dipinjam';
                                    $warna = 'primary';
                                }
                            @endphp

                            <span class="badge bg-{{ $warna }}">
                                {{ $status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- STYLE TAMBAHAN --}}
<style>
    /* CARD FILTER DIBERI SENTUHAN WARNA */
    .filter-card {
        border-left: 5px solid #22c55e; /* hijau */
        background: #f0fdf4; /* hijau sangat soft */
    }

    /* INPUT JUGA DIKASIH FEEL */
    .filter-input {
        border: 1px solid #bbf7d0;
        background-color: #f9fffb;
    }

    .filter-input:focus {
        border-color: #22c55e;
        box-shadow: 0 0 0 0.1rem rgba(34,197,94,0.2);
    }
</style>
@endsection