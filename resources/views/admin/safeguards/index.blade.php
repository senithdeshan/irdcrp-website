@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="section-title mb-1">Safeguard resources</h2>
            <p class="text-muted mb-0">Manage descriptions, images, and reports for both Safeguard sections.</p>
        </div>
        <a href="{{ route('admin.safeguards.create') }}" class="btn btn-green">Add item</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $grouped = $items->groupBy('category');
    @endphp

    @foreach ($categories as $categoryKey => $categoryLabel)
        @php
            $sectionItems = $grouped->get($categoryKey, collect());
        @endphp
        <div class="mb-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <div>
                    <h3 class="h5 fw-bold text-[#0A3D62] mb-1">{{ $categoryLabel }}</h3>
                    <p class="text-muted small mb-0">{{ $sectionItems->count() }} item(s) in this section</p>
                </div>
                <a href="{{ route('admin.safeguards.create', ['category' => $categoryKey]) }}" class="btn btn-sm btn-outline-success">
                    + Add to this section
                </a>
            </div>

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
                            @forelse ($sectionItems as $item)
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
                                        <a href="{{ route('admin.safeguards.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form class="d-inline" method="POST" action="{{ route('admin.safeguards.destroy', $item) }}" onsubmit="return confirm('Remove this safeguard item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted p-4">
                                        No items yet for this section.
                                        <a href="{{ route('admin.safeguards.create', ['category' => $categoryKey]) }}">Add the first one</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</section>
@endsection
