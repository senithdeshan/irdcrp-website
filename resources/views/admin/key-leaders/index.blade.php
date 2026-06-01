@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="section-title mb-0">Key leaders</h2>
        <a href="{{ route('admin.key-leaders.create') }}" class="btn btn-green">Add leader</a>
    </div>
    <p class="text-muted small mb-4">Photos and text shown on the home page. Use <strong>Group</strong> to split the section into Key Leaders and Project Staff. Sort uses lower numbers first inside each group.</p>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="table-responsive card feature-card">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Sort</th>
                    <th>Group</th>
                    <th>Photo</th>
                    <th>Role (EN)</th>
                    <th>Organisation (EN)</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->sort_order }}</td>
                        <td>
                            <span class="badge text-bg-{{ $item->group === 'project_staff' ? 'danger' : 'primary' }}">
                                {{ $item->groupLabel() }}
                            </span>
                        </td>
                        <td style="width: 72px">
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}" alt="" class="rounded" style="width: 56px; height: 56px; object-fit: cover;">
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ Str::limit($item->role_en, 40) }}</td>
                        <td class="small text-muted">{{ Str::limit($item->org_en, 60) }}</td>
                        <td>
                            @if($item->is_active)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.key-leaders.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form class="d-inline" method="POST" action="{{ route('admin.key-leaders.destroy', $item) }}" onsubmit="return confirm('Remove this leader?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-muted p-4">No key leaders yet. Add entries or run <code class="small">php artisan db:seed --class=KeyLeaderSeeder</code> to import defaults.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
