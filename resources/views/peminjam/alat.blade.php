@extends('layouts.peminjam')

@section('content')
@php
    use Carbon\Carbon;
@endphp

<div class="container-fluid px-4">
    <div class="mt-4 mb-4">
        <h1 class="h3 fw-bold text-dark">Daftar Alat & Inventaris</h1>
        <p class="text-muted small">Pilih alat yang tersedia dan ajukan peminjaman dengan mudah.</p>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small text-uppercase fw-bold text-muted">
                            <th class="ps-4 py-3">No</th>
                            <th>Nama Alat</th>
                            <th>Stok</th>
                            <th>Kondisi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alats as $alat)
                        <tr>
                            <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $alat['nama'] }}</div>
                                <small class="text-muted">ID: #INV-{{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}</small>
                            </td>
                            <td>
                                @if($alat['stok'] > 0)
                                    <span class="badge bg-success-subtle text-success px-3">{{ $alat['stok'] }} Unit</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3">Habis</span>
                                @endif
                            </td>
                            <td>
                                @if($alat['kondisi'] == 'Baik')
                                    <span class="badge rounded-pill border border-success text-success px-3">
                                        <i class="fas fa-check-circle me-1"></i> {{ $alat['kondisi'] }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill border border-warning text-warning px-3">
                                        <i class="fas fa-exclamation-triangle me-1"></i> {{ $alat['kondisi'] }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($alat['stok'] > 0)
                                    <button class="btn btn-primary btn-sm px-3 shadow-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalPinjam{{ $loop->iteration }}">
                                        <i class="fas fa-hand-holding me-1"></i> Pinjam Alat
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm px-3 disabled">
                                        Tidak Tersedia
                                    </button>
                                @endif
                            </td>
                        </tr>

                        {{-- MODAL FORM PINJAM --}}
                        <div class="modal fade" id="modalPinjam{{ $loop->iteration }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold">Form Peminjaman Alat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('peminjam.peminjaman.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="alert alert-primary bg-primary-subtle border-0 small text-primary mb-4">
                                                Anda akan meminjam: <strong>{{ $alat['nama'] }}</strong>
                                            </div>
                                            
                                            <input type="hidden" name="alat_id" value="{{ $loop->iteration }}"> {{-- ID Alat --}}

                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Nama Lengkap</label>
                                                <input type="text" name="nama_peminjam" class="form-control" placeholder="Masukkan nama Anda" required>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label small fw-bold">Tanggal Pinjam</label>
                                                    <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label small fw-bold">Jatuh Tempo</label>
                                                    <input type="date" name="jatuh_tempo" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="mb-0">
                                                <label class="form-label small fw-bold">Keperluan</label>
                                                <textarea name="keperluan" class="form-control" rows="3" placeholder="Contoh: Praktikum di Lab" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light btn-sm text-muted" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary btn-sm px-4">Kirim Pengajuan</button>
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
</div>

<style>
    .bg-success-subtle { background-color: rgba(25, 135, 84, 0.1) !important; }
    .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.1) !important; }
    .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.1) !important; }
    
    .form-control {
        border-radius: 8px;
        padding: 0.6rem 0.75rem;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
    }
    
    .form-control:focus {
        background-color: #fff;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05);
        border-color: #0d6efd;
    }

    .modal-content {
        border-radius: 15px;
    }
</style>
@endsection