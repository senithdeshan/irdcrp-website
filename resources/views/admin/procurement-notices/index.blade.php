@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="section-title mb-1">Procurement Notices</h2>
            <p class="text-muted mb-0">Manage notices, bidding documents, award updates, and attached PDF reports.</p>
        </div>
        <a href="{{ route('admin.procurement-notices.create') }}" class="btn btn-green">Add notice</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card feature-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Reference</th>
                        <th>Title</th>
                        <th>Closing</th>
                        <th>Status</th>
                        <th>PDFs</th>
                        <th>Order</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $notice)
                        <tr>
                            <td class="text-muted">{{ $notice->reference_no ?: '-' }}</td>
                            <td>
                                <strong>{{ $notice->title }}</strong>
                                <div class="small text-muted">{{ ucfirst($notice->notice_type) }}</div>
                            </td>
                            <td>{{ $notice->closing_date?->format('Y-m-d') ?: '-' }}</td>
                            <td>
                                <span class="badge {{ $notice->status === 'open' ? 'bg-success' : ($notice->status === 'closed' ? 'bg-secondary' : 'bg-warning text-dark') }}">
                                    {{ ucfirst($notice->status) }}
                                </span>
                            </td>
                            <td>{{ count($notice->documents ?? []) }}</td>
                            <td>{{ $notice->sort_order }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.procurement-notices.edit', $notice) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.procurement-notices.destroy', $notice) }}" onsubmit="return confirm('Delete this procurement notice and all attached PDFs?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-5 text-center text-muted">No procurement notices yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
