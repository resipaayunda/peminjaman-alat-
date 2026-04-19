@extends('layouts.peminjam')

@section('content')
@php
    use Carbon\Carbon;
@endphp

<div class="container-fluid px-4">

    {{-- HEADER --}}
    <div class="mt-4 mb-4">
        <h1 class="h3 fw-bold text-dark">Pengembalian Alat</h1>
        <p class="text-muted small">Kembalikan alat yang sedang dipinjam</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama</th>
                            <th>Barang</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($peminjamans as $p)
                        @php
                            $jatuhTempo = Carbon::parse($p->jatuh_tempo);
                            $telat = now()->gt($jatuhTempo);
                        @endphp

                        <tr>
                            <td class="ps-4">{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $p->nama_peminjam }}</td>
                            <td>{{ $p->barang }}</td>
                            <td>{{ Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                            <td>{{ $jatuhTempo->format('d M Y') }}</td>

                            <td>
                                @if($telat)
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-success">Dipinjam</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <form action="{{ route('peminjam.peminjaman.kembalikan', $p->id) }}"
                                      method="POST">
                                    @csrf
                                    <button class="btn btn-primary btn-sm"
                                            onclick="return confirm('Yakin ingin mengembalikan alat ini?')">
                                        Kembalikan
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Tidak ada alat yang sedang dipinjam
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