@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Home videos</h2>
        <a href="{{ route('admin.home-videos.create') }}" class="btn btn-green">Add video</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="table-responsive rounded-3 border bg-white shadow-sm">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>YouTube URL</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="fw-semibold">{{ $item->title }}</td>
                        <td>
                            <a href="{{ $item->youtube_url }}" target="_blank" rel="noopener noreferrer" class="small">
                                {{ \Illuminate\Support\Str::limit($item->youtube_url, 60) }}
                            </a>
                        </td>
                        <td>{{ $item->sort_order }}</td>
                        <td>
                            <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.home-videos.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form method="POST" action="{{ route('admin.home-videos.destroy', $item) }}" onsubmit="return confirm('Delete this video?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No home videos yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection

