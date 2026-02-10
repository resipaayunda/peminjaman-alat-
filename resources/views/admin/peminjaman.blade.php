@extends('layouts.admin')

@section('content')
@php
    use Carbon\Carbon;
    $today = Carbon::today();
@endphp

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4 h3 fw-bold text-gray-800">Peminjaman</h1>

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-primary border-4">
                <div class="card-body py-3">
                    <div class="small text-muted fw-bold text-uppercase">Total Dipinjam</div>
                    <div class="h4 mb-0 fw-bold">
                        {{ $peminjamans->whereNull('tanggal_kembali')->count() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-success border-4">
                <div class="card-body py-3">
                    <div class="small text-muted fw-bold text-uppercase">Sudah Kembali</div>
                    <div class="h4 mb-0 fw-bold">
                        {{ $peminjamans->whereNotNull('tanggal_kembali')->count() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-danger border-4">
                <div class="card-body py-3">
                    <div class="small text-muted fw-bold text-uppercase">Terlambat</div>
                    <div class="h4 mb-0 fw-bold text-danger">
                        {{ $peminjamans->filter(fn($p) =>
                            is_null($p->tanggal_kembali) &&
                            Carbon::parse($p->jatuh_tempo)->lt($today)
                        )->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">Daftar Peminjaman</h6>

            {{-- TOMBOL TAMBAH --}}
            <button class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalPinjam">
                <i class="fas fa-plus"></i> Tambah Peminjaman
            </button>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nama</th>
                        <th>Barang</th>
                        <th>Tgl Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($peminjamans as $p)
                @php
                    $jatuhTempo = Carbon::parse($p->jatuh_tempo);
                    $terlambat = is_null($p->tanggal_kembali) && $jatuhTempo->lt($today);
                @endphp

                <tr>
                    <td class="ps-4 fw-bold">{{ $p->nama_peminjam }}</td>
                    <td>{{ $p->barang }}</td>
                    <td>{{ Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                    <td>{{ $jatuhTempo->format('d M Y') }}</td>
                    <td>
                        {{ $p->tanggal_kembali
                            ? Carbon::parse($p->tanggal_kembali)->format('d M Y')
                            : '-' }}
                    </td>

                    {{-- STATUS --}}
                    <td>
                        @if ($p->tanggal_kembali)
                            <span class="badge bg-success px-3">Kembali</span>
                        @elseif ($terlambat)
                            <span class="badge bg-danger px-3">Terlambat</span>
                        @else
                            <span class="badge bg-primary px-3">Dipinjam</span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="text-center">
                        {{-- Kembalikan --}}
                        @if (is_null($p->tanggal_kembali))
                        <form action="{{ route('admin.peminjaman.update', $p->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-sm btn-outline-success"
                                    onclick="return confirm('Yakin barang dikembalikan?')">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        @endif
                        
                        <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $p->id }}">
                            <i class="fas fa-edit"></i>
                        </button>

                        {{-- Hapus --}}
                        @if ($p->tanggal_kembali || $terlambat)
                        <form action="{{ route('admin.peminjaman.destroy', $p->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Yakin hapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        Belum ada data
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH PEMINJAMAN --}}
<div class="modal fade" id="modalPinjam" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Peminjam</label>
                        <input type="text" name="nama_peminjam" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Barang</label>
                        <input type="text" name="barang" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Jatuh Tempo</label>
                            <input type="date" name="jatuh_tempo" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT PEMINJAMAN --}}
@foreach ($peminjamans as $p)
<div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.peminjaman.update', $p->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Peminjaman</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Peminjam</label>
                        <input type="text" name="nama_peminjam"
                               value="{{ $p->nama_peminjam }}"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Barang</label>
                        <input type="text" name="barang"
                               value="{{ $p->barang }}"
                               class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam"
                                   value="{{ $p->tanggal_pinjam }}"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Jatuh Tempo</label>
                            <input type="date" name="jatuh_tempo"
                                   value="{{ $p->jatuh_tempo }}"
                                   class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit"
                            class="btn btn-warning btn-sm">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
