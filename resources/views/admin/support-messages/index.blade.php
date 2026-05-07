@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <h2 class="section-title mb-0">Support Messages</h2>
        <form method="GET" class="d-flex align-items-center gap-2">
            <label for="status" class="small text-muted">Status</label>
            <select id="status" name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="new" @selected($status === 'new')>New</option>
                <option value="in_progress" @selected($status === 'in_progress')>In Progress</option>
                <option value="resolved" @selected($status === 'resolved')>Resolved</option>
            </select>
        </form>
    </div>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="card feature-card p-0 overflow-hidden">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->subject }}</td>
                        <td>
                            <span class="badge text-bg-{{ $item->status === 'resolved' ? 'success' : ($item->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                {{ str_replace('_', ' ', $item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.support-messages.edit', $item) }}" class="btn btn-sm btn-primary">Open</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted p-4">No support messages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $items->links() }}
    </div>
</section>
@endsection
