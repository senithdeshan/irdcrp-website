@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="section-title mb-1">GRM Complaints</h2>
            <p class="text-muted mb-0">Search and manage grievances submitted from the public GRM page.</p>
        </div>

        <form method="GET" id="grm-filter-form" class="d-flex flex-wrap align-items-center gap-2 ms-md-auto">
            <label for="grm-search" class="visually-hidden">Search complaints</label>
            <input
                type="search"
                id="grm-search"
                name="q"
                class="form-control form-control-sm"
                value="{{ $search }}"
                placeholder="Search name, email, message, notes…"
                style="min-width: 14rem; max-width: 20rem;"
            >
            <label for="status" class="visually-hidden">Status</label>
            <select id="status" name="status" class="form-select form-select-sm" style="max-width: 11rem;" onchange="this.form.submit()">
                <option value="">All statuses</option>
                <option value="new" @selected($status === 'new')>Unsolved (New)</option>
                <option value="in_progress" @selected($status === 'in_progress')>In Progress</option>
                <option value="solved" @selected($status === 'solved')>Solved</option>
            </select>
            @if(filled($search) || filled($status))
                <a href="{{ route('admin.grm-complaints.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            @endif
        </form>
    </div>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <x-grm-summary-dashboard :stats="$stats" />

    @if(filled($search) || filled($status))
        <p class="small text-muted mb-3">
            Showing filtered results
            @if(filled($search))
                for “{{ $search }}”
            @endif
            @if(filled($status))
                · status: {{ $status === 'new' ? 'Unsolved' : str_replace('_', ' ', ucfirst($status)) }}
            @endif
        </p>
    @endif

    <div class="card feature-card p-0 overflow-hidden">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
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
                        <td class="small text-muted" style="max-width: 18rem;">{{ str($item->message)->limit(90) }}</td>
                        <td>
                            <span class="badge text-bg-{{ $item->status === 'solved' ? 'success' : ($item->status === 'in_progress' ? 'warning' : 'danger') }}">
                                @if($item->status === 'new')
                                    Unsolved
                                @else
                                    {{ str_replace('_', ' ', ucfirst($item->status)) }}
                                @endif
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.grm-complaints.edit', $item) }}" class="btn btn-sm btn-primary">Open</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted p-4">
                            @if(filled($search) || filled($status))
                                No complaints matched your filters.
                            @else
                                No GRM complaints found.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $items->links() }}
    </div>
</section>

<script>
    (function () {
        const form = document.getElementById('grm-filter-form');
        const searchInput = document.getElementById('grm-search');

        if (!form || !searchInput) {
            return;
        }

        let timer = null;

        searchInput.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(function () {
                form.requestSubmit();
            }, 350);
        });
    })();
</script>
@endsection
