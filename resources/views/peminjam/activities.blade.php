@extends('layouts.peminjam')

@section('content')
@php
    use Carbon\Carbon;
@endphp

<div class="container-fluid px-4">
    <div class="mt-4 mb-4">
        <h1 class="h3 fw-bold text-dark">Log Aktivitas Peminjam</h1>
        <p class="text-muted small">Catatan seluruh aktivitas peminjam di sistem.</p>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-white py-3 border-0">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-stream me-2"></i>Aktivitas Terbaru
            </h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="small text-muted text-uppercase fw-bold">
                            <th class="ps-4 py-3">Waktu</th>
                            <th>Peminjam</th>
                            <th>Aksi</th>
                            <th>Modul</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activities as $log)
                        <tr>
                            <td class="ps-4">
                                <div class="small fw-bold">
                                    {{ Carbon::parse($log->created_at)->format('d M Y') }}
                                </div>
                                <div class="text-muted small">
                                    {{ Carbon::parse($log->created_at)->format('H:i:s') }} WIB
                                </div>
                            </td>

                            <td>
                                <div class="fw-bold small">
                                    {{ $log->peminjam->name ?? '-' }}
                                </div>
                                <div class="text-muted small">
                                    {{ $log->peminjam->role ?? '-' }}
                                </div>
                            </td>

                            <td class="small">
                                {{ $log->description }}
                            </td>

                            <td>
                                <span class="badge bg-secondary-subtle text-secondary">
                                    {{ $log->model ?? '-' }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if($log->action == 'delete')
                                    <i class="fas fa-circle text-danger"></i>
                                @elseif($log->action == 'create')
                                    <i class="fas fa-circle text-success"></i>
                                @elseif($log->action == 'update')
                                    <i class="fas fa-circle text-warning"></i>
                                @elseif($log->action == 'login')
                                    <i class="fas fa-circle text-primary"></i>
                                @elseif($log->action == 'logout')
                                    <i class="fas fa-circle text-dark"></i>
                                @else
                                    <i class="fas fa-circle text-secondary"></i>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                Belum ada aktivitas peminjam.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white">
            <div class="d-flex justify-content-end">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection