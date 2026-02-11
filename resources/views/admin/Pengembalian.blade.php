@extends('layouts.admin')

@section('content')
@php
    use Carbon\Carbon;
@endphp

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4 h3 fw-bold text-gray-800">Pengembalian</h1>

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-success border-4">
                <div class="card-body py-3">
                    <div class="small text-muted fw-bold text-uppercase">Sudah Dikembalikan</div>
                    <div class="h4 mb-0 fw-bold text-success">
                        {{ $pengembalians->count() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-danger border-4">
                <div class="card-body py-3">
                    <div class="small text-muted fw-bold text-uppercase">Terlambat</div>
                    <div class="h4 mb-0 fw-bold text-danger">
                        {{ $pengembalians->filter(fn($p) =>
                            Carbon::parse($p->tanggal_kembali)->gt(Carbon::parse($p->jatuh_tempo))
                        )->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary">Riwayat Pengembalian</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama</th>
                            <th>Barang</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pengembalians as $p)
                        @php
                            $jatuhTempo = Carbon::parse($p->jatuh_tempo);
                            $tanggalKembali = Carbon::parse($p->tanggal_kembali);
                            $telat = $tanggalKembali->gt($jatuhTempo);
                            $hariTelat = $telat ? $tanggalKembali->diffInDays($jatuhTempo) : 0;
                            $denda = $hariTelat * 10000;
                        @endphp

                        <tr>
                            <td class="ps-4 fw-bold">{{ $p->nama_peminjam }}</td>
                            <td>{{ $p->barang }}</td>
                            <td>{{ Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                            <td>{{ $jatuhTempo->format('d M Y') }}</td>
                            <td>{{ $tanggalKembali->format('d M Y') }}</td>

                            <td>
                                @if ($telat)
                                    <span class="badge bg-danger px-3">Terlambat</span>
                                @else
                                    <span class="badge bg-success px-3">Tepat Waktu</span>
                                @endif
                            </td>

                            <td>
                                @if ($telat)
                                    <span class="text-danger fw-bold">
                                        Rp {{ number_format($denda, 0, ',', '.') }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="text-center">
                                {{-- EDIT --}}
                                <button class="btn btn-sm btn-outline-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editKembali{{ $p->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                {{-- DELETE --}}
                                <form action="{{ route('admin.pengembalian.destroy', $p->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Hapus riwayat pengembalian?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL EDIT --}}
                        <div class="modal fade" id="editKembali{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <form action="{{ route('admin.pengembalian.update', $p->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Pengembalian</h5>
                                            <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small">
                                                    Tanggal Kembali
                                                </label>
                                                <input type="date"
                                                       name="tanggal_kembali"
                                                       class="form-control"
                                                       value="{{ $p->tanggal_kembali }}"
                                                       required>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button"
                                                    class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                    class="btn btn-primary btn-sm">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Belum ada data pengembalian
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection
