@extends('layouts.peminjam')

@section('content')
<div class="container-fluid px-4">

    <div class="mt-4 mb-4">
        <h1 class="h3 fw-bold text-dark">Daftar Alat & Inventaris</h1>
        <p class="text-muted small">Pilih alat dan ajukan peminjaman.</p>
    </div>

    {{-- FILTER --}}
    <div class="card mb-3 shadow-sm border-0">
        <div class="card-body">
            <form method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <select name="kategori_id" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}" 
                                    {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($alats as $alat)
                    <tr>
                        <td class="ps-4">{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $alat->nama_barang }}</td>
                        <td>{{ $alat->kategori->nama ?? '-' }}</td>

                        <td>
                            @if($alat->stok > 0)
                                <span class="badge bg-success">{{ $alat->stok }}</span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($alat->stok > 0)
                                <button class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalPinjam{{ $alat->id }}">
                                    <i class="fas fa-hand-holding me-1"></i> Pinjam
                                </button>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    Tidak Tersedia
                                </button>
                            @endif
                        </td>
                    </tr>

                    {{-- MODAL --}}
                    <div class="modal fade" id="modalPinjam{{ $alat->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Form Peminjaman</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form action="{{ route('peminjam.alat.store') }}" method="POST">
                                    @csrf

                                    <div class="modal-body">

                                        <div class="alert alert-primary">
                                            <strong>{{ $alat->nama_barang }}</strong>
                                        </div>

                                        <input type="hidden" name="barang_id" value="{{ $alat->id }}">

                                        {{-- JUMLAH --}}
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Jumlah Pinjam</label>
                                            <input type="number" name="jumlah" 
                                                   class="form-control" min="1" required>
                                        </div>

                                        {{-- TANGGAL --}}
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold small">Tanggal Pinjam</label>
                                                <input type="date" name="tanggal_pinjam"
                                                       class="form-control"
                                                       value="{{ date('Y-m-d') }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold small">Jatuh Tempo</label>
                                                <input type="date" name="jatuh_tempo"
                                                       class="form-control" required>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Kirim
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection