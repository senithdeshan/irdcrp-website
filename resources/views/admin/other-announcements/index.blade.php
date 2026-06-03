@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1">Other announcements</h2>
            <p class="text-muted mb-0">Manage general announcements under Announcements → Other.</p>
        </div>
        <a href="{{ route('admin.other-announcements.create') }}" class="btn btn-green">Add announcement</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card feature-card p-0 overflow-hidden">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order</th>
                    <th>Title</th>
                    <th>Published</th>
                    <th>File</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $item->sort_order }}</td>
                        <td>
                            <strong>{{ $item->title }}</strong>
                            <div class="small text-muted">{{ str($item->description)->limit(100) }}</div>
                        </td>
                        <td>{{ $item->published_date?->format('Y-m-d') ?? '—' }}</td>
                        <td>
                            @if ($item->document_path)
                                <span class="badge text-bg-light border">{{ $item->documentTypeLabel() }}</span>
                            @else
                                <span class="text-muted small">No file</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge text-bg-{{ $item->status === 'published' ? 'success' : 'secondary' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.other-announcements.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form class="d-inline" method="POST" action="{{ route('admin.other-announcements.destroy', $item) }}" onsubmit="return confirm('Delete this announcement?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted p-4">No other announcements yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
