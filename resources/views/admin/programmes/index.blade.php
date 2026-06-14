@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Programmes</h2>
        <a href="{{ route('admin.programmes.create') }}" class="btn btn-green">Add programme</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card feature-card p-0 overflow-hidden">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Order</th><th>Image</th><th>Title</th><th>Component</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->sort_order }}</td>
                        <td><img src="{{ str_starts_with($item->image ?? '', 'images/') ? asset($item->image) : asset('storage/'.$item->image) }}" alt="" style="width: 88px; height: 56px; object-fit: cover;" class="rounded"></td>
                        <td><strong>{{ $item->title }}</strong><div class="small text-muted">/programmes/{{ $item->slug }}</div></td>
                        <td>
                            @if($item->projectComponent)
                                <span class="badge text-bg-light border">Component {{ $item->projectComponent->component_number }}</span>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td><span class="badge text-bg-{{ $item->status === 'published' ? 'success' : 'secondary' }}">{{ $item->status }}</span></td>
                        <td class="text-nowrap">
                            <a href="{{ route('programmes.show', $item) }}" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.programmes.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form class="d-inline" method="POST" action="{{ route('admin.programmes.destroy', $item) }}" onsubmit="return confirm('Delete this programme?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted p-4">No programmes found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
