@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1">FAQs</h2>
            <p class="text-muted mb-0">Manage questions shown on the public FAQ page.</p>
        </div>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-green">Add FAQ</a>
    </div>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="card feature-card p-0 overflow-hidden">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order</th>
                    <th>Question</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->sort_order }}</td>
                        <td>
                            <strong>{{ $item->question }}</strong>
                            <div class="small text-muted">{{ str($item->answer)->limit(120) }}</div>
                        </td>
                        <td>
                            <span class="badge text-bg-{{ $item->status === 'published' ? 'success' : 'secondary' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.faqs.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form class="d-inline" method="POST" action="{{ route('admin.faqs.destroy', $item) }}" onsubmit="return confirm('Delete this FAQ item?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted p-4">No FAQ items found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
