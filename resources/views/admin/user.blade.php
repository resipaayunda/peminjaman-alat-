@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen User</h1>
        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
            <i class="fas fa-plus fa-sm me-1"></i> Tambah User Baru
        </button>
    </div>

    {{-- Statistik --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-primary border-4">
                <div class="card-body">
                    <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Users</div>
                    <div class="h5 mb-0 fw-bold">{{ $users->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel User --}}
    <div class="card border-0 shadow mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">Daftar Pengguna</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama & Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="ps-4">
                                <strong>{{ $user->name }}</strong><br>
                                <small class="text-muted">{{ $user->email }}</small>
                            </td>
                            <td>{{ $user->role }}</td>
                            <td class="text-success">Aktif</td>
                            <td class="text-center">

                                {{-- Edit --}}
                                <button
                                    class="btn btn-sm btn-light text-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditUser{{ $user->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin hapus user ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-light text-danger">
                                        <i class="fas fa-trash"></i>
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

{{-- ================= MODAL TAMBAH USER ================= --}}
<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            {{-- Error --}}
            @if ($errors->any())
            <div class="alert alert-danger m-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input name="name" class="form-control mb-3" placeholder="Nama lengkap" required>
                    <input name="email" type="email" class="form-control mb-3" placeholder="Email" required>
                    <input name="password" type="password" class="form-control mb-3" placeholder="Password" required>

                    <select name="role" class="form-select" required>
                        <option value="">Pilih Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Petugas">Petugas</option>
                        <option value="Peminjam">Peminjam</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= MODAL EDIT USER ================= --}}
@foreach ($users as $user)
<div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input name="name" class="form-control mb-3" value="{{ $user->name }}" required>
                    <input name="email" type="email" class="form-control mb-3" value="{{ $user->email }}" required>

                    <select name="role" class="form-select" required>
                        <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Petugas" {{ $user->role == 'Petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="Peminjam" {{ $user->role == 'Peminjam' ? 'selected' : '' }}>Peminjam</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endforeach

@endsection
