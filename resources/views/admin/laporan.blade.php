@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Peminjaman</h1>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-danger btn-sm px-3">
                <i class="fas fa-file-pdf me-1"></i> Cetak PDF
            </button>
            <button class="btn btn-outline-success btn-sm px-3">
                <i class="fas fa-file-excel me-1"></i> Ekspor Excel
            </button>
        </div>
    </div>

    {{-- Filter Laporan --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Dari Tanggal</label>
                    <input type="date" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Sampai Tanggal</label>
                    <input type="date" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Kategori Barang</label>
                    <select class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        <option value="laptop">Laptop</option>
                        <option value="proyektor">Proyektor</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-filter me-1"></i> Filter Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small">
                            <th class="ps-4 py-3">No</th>
                            <th>Tanggal Pinjam</th>
                            <th>Nama Peminjam</th>
                            <th>Barang</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <tr>
                            <td class="ps-4">1</td>
                            <td>01 Feb 2024</td>
                            <td>Andi Wijaya</td>
                            <td>Laptop ASUS ROG</td>
                            <td>05 Feb 2024</td>
                            <td><span class="text-success fw-bold">Selesai</span></td>
                        </tr>
                        <tr>
                            <td class="ps-4">2</td>
                            <td>03 Feb 2024</td>
                            <td>Rina Sari</td>
                            <td>Proyektor Epson</td>
                            <td>-</td>
                            <td><span class="text-primary fw-bold">Masih Dipinjam</span></td>
                        </tr>
                        {{-- Iterasi data lainnya --}}
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Footer Tabel untuk Total --}}
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="row text-center small fw-bold text-muted">
                <div class="col border-end">Total Transaksi: 40</div>
                <div class="col border-end text-success">Selesai: 37</div>
                <div class="col text-primary">Aktif: 3</div>
            </div>
        </div>
    </div>
</div>
@endsection