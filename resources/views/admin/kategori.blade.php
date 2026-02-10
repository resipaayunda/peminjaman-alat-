@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 pb-5">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-end mt-5 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Manajemen Kategori</h1>
            <p class="text-muted small mb-0">Kelola kategori inventaris.</p>
        </div>
        <button class="btn btn-primary fw-bold"
                data-bs-toggle="modal"
                data-bs-target="#modalTambahKategori">
            <i class="fas fa-plus-circle me-2"></i>Tambah Kategori
        </button>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                {{-- TABLE HEADER --}}
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah</th>
                        <th>Terakhir Update</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- TABLE BODY --}}
                <tbody>
                    @foreach ($kategoris as $index => $kategori)
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>

                        <td>
                            <span class="fw-bold">{{ $kategori->nama }}</span>
                        </td>

                        {{-- JUMLAH BARANG --}}
                        <td>
                            <span class="badge bg-info">
                                {{ $kategori->barangs_count ?? 0 }} Barang
                            </span>
                        </td>

                        {{-- TERAKHIR UPDATE --}}
                        <td class="text-muted">
                            {{ $kategori->updated_at->diffForHumans() }}
                        </td>

                        {{-- AKSI --}}
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-white btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $kategori->id }}">
                                    <i class="fas fa-edit text-primary"></i>
                                </button>

                                <form action="{{ route('admin.kategori.destroy', $kategori->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-white btn-sm"
                                            onclick="return confirm('Yakin hapus?')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambahKategori" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   placeholder="Contoh: Laptop"
                                   required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Jumlah</label>
                            <input type="number"
                                   name="jumlah"
                                   class="form-control"
                                   min="1"
                                   placeholder="Masukkan jumlah"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- MODAL EDIT --}}
@foreach ($kategoris as $kategori)
<div class="modal fade" id="modalEdit{{ $kategori->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="{{ $kategori->nama }}"
                           required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
