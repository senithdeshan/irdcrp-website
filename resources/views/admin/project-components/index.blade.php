@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Project Components</h2>
        <a href="{{ route('admin.project-components.create') }}" class="btn btn-green">Add component</a>
    </div>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="card feature-card p-0 overflow-hidden">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order</th>
                    <th>Component</th>
                    <th>Budget</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->sort_order }}</td>
                        <td>
                            <strong>Component {{ $item->component_number }}</strong>
                            <div class="small text-muted">{{ $item->title }}</div>
                        </td>
                        <td>{{ $item->budget ?: '-' }}</td>
                        <td>
                            <span class="badge text-bg-{{ $item->status === 'published' ? 'success' : 'secondary' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.project-components.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form class="d-inline" method="POST" action="{{ route('admin.project-components.destroy', $item) }}" onsubmit="return confirm('Delete this component?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted p-4">No project components found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
