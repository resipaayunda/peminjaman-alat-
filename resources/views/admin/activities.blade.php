@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Log Aktivitas Admin</h1>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Admin</th>
                        <th>Aksi</th>
                        <th>Model</th>
                        <th>Deskripsi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $activity)
                        <tr>
                            <td>{{ $activity->id }}</td>
                            <td>{{ $activity->admin->name }}</td>
                            <td>{{ $activity->action }}</td>
                            <td>{{ $activity->model ?? '-' }}</td>
                            <td>{{ $activity->description ?? '-' }}</td>
                            <td>{{ $activity->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
