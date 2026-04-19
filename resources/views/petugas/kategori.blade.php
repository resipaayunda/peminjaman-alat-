@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4 pb-5">

    {{-- HEADER --}}
    <div class="mt-5 mb-4">
        <h1 class="h3 fw-bold text-dark mb-1">Manajemen Kategori</h1>
        <p class="text-muted small mb-0">Kelola kategori inventaris.</p>
    </div>

    <div class="row">

        {{-- FORM TAMBAH --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    Tambah Kategori
                </div>

                <div class="card-body">
                    <form action="{{ route('petugas.kategori.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   placeholder="Contoh: Laptop"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Nama Kategori</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($kategoris as $index => $kategori)
                            <tr>
                                <td class="ps-4">{{ $index + 1 }}</td>

                                <td class="fw-bold">
                                    {{ $kategori->nama }}
                                </td>

                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#editKategori{{ $kategori->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('petugas.kategori.destroy', $kategori->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- FORM EDIT --}}
                            <tr class="collapse" id="editKategori{{ $kategori->id }}">
                                <td colspan="4">
                                    <form action="{{ route('petugas.kategori.update', $kategori->id) }}"
                                          method="POST"
                                          class="d-flex gap-2">
                                        @csrf
                                        @method('PUT')

                                        <input type="text"
                                               name="nama"
                                               value="{{ $kategori->nama }}"
                                               class="form-control">

                                        <button class="btn btn-primary btn-sm">
                                            Simpan
                                        </button>
                                    </form>
                                </td>
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