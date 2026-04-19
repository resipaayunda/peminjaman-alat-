@extends('layouts.admin')

@section('content')
<div class="container mt-4">

     {{-- HEADER --}}
    <div class="mt-5 mb-4">
        <h1 class="h3 fw-bold text-dark mb-1">Manajemen Barang</h1>
        <p class="text-muted small mb-0">Kelola barang dan kategori</p>
    </div>

    <div class="row">

        {{-- FORM TAMBAH --}}
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h5 class="mb-3">Tambah Barang</h5>

                <form action="{{ route('admin.barang.store') }}" method="POST">
                    @csrf

                    <div class="mb-2">
                        <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" required>
                    </div>

                    <div class="mb-2">
                        <select name="kategori_id" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <input type="number" name="stok" class="form-control" placeholder="Jumlah Barang" min="1" required>
                    </div>

                    <button class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="col-md-8">
            <div class="card p-3 shadow-sm">
                <h5 class="mb-3">Daftar Barang</h5>

                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($barangs as $b)
                        <tr>
                            <td class="fw-bold">{{ $b->nama_barang }}</td>
                            <td>{{ $b->kategori->nama }}</td>
                            <td>
                                <span class="badge bg-info px-3 py-2">
                                    {{ $b->stok }}
                                </span>
                            </td>

                            <td class="text-center">
                                <button class="btn btn-warning btn-sm"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#edit{{ $b->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('admin.barang.destroy', $b->id) }}"
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

                        {{-- FORM EDIT (MUNCUL SAAT DIKLIK) --}}
                        <tr class="collapse" id="edit{{ $b->id }}">
                            <td colspan="4">
                                <form action="{{ route('admin.barang.update', $b->id) }}"
                                      method="POST"
                                      class="d-flex gap-2">
                                    @csrf
                                    @method('PUT')

                                    <input type="text"
                                           name="nama_barang"
                                           value="{{ $b->nama_barang }}"
                                           class="form-control">

                                    <input type="number"
                                           name="stok"
                                           value="{{ $b->stok }}"
                                           class="form-control"
                                           style="max-width:120px">

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
@endsection