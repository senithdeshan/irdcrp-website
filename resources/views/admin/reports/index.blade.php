@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="section-title mb-1">Reports</h2>
            <p class="text-muted mb-0">Manage descriptions, images, and downloadable files for the public Reports page.</p>
        </div>
        <a href="{{ route('admin.reports.create') }}" class="btn btn-green">Add report</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card feature-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle irdc-admin-safeguard-table">
                <thead class="table-light">
                    <tr>
                        <th style="width:4rem">Order</th>
                        <th>Title & description</th>
                        <th style="width:8rem">Images</th>
                        <th style="width:11rem">Report file</th>
                        <th style="width:7rem">Date</th>
                        <th style="width:6rem">Status</th>
                        <th style="width:9rem"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td class="text-muted">{{ $item->sort_order }}</td>
                            <td>
                                <strong>{{ $item->title }}</strong>
                                @if ($item->description)
                                    <div class="small text-muted mt-1">{{ str($item->description)->limit(140) }}</div>
                                @endif
                            </td>
                            <td>
                                @if (count($item->images ?? []) > 0)
                                    <span class="badge text-bg-light border">{{ count($item->images) }} image(s)</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->document_path)
                                    <span class="badge text-bg-primary">{{ $item->documentTypeLabel() }}</span>
                                    <div class="small text-muted text-truncate mt-1" style="max-width:10rem" title="{{ $item->document_original_name }}">
                                        {{ $item->document_original_name ?: 'Uploaded file' }}
                                    </div>
                                @else
                                    <span class="text-muted small">No file</span>
                                @endif
                            </td>
                            <td class="small text-muted">
                                {{ $item->document_date?->format('M j, Y') ?? '—' }}
                            </td>
                            <td>
                                <span class="badge text-bg-{{ $item->status === 'published' ? 'success' : 'secondary' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.reports.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.reports.destroy', $item) }}" onsubmit="return confirm('Remove this report?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted p-4">
                                No reports yet. <a href="{{ route('admin.reports.create') }}">Add the first one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
