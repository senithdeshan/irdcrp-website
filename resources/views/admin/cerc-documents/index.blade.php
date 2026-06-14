@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="section-title mb-1">CERC Documents</h2>
            <p class="text-muted mb-0">Manage downloadable files for the public CERC page.</p>
        </div>
        <a href="{{ route('admin.cerc-documents.create') }}" class="btn btn-green">Add CERC document</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please check the CERC details.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card feature-card p-4 mb-4">
        <h3 class="h5 fw-bold mb-3">CERC page content</h3>
        <form method="POST" action="{{ route('admin.cerc-documents.settings.update') }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Hero eyebrow</label>
                    <input type="text" name="hero_eyebrow" class="form-control" value="{{ old('hero_eyebrow', $cerc['hero_eyebrow'] ?? '') }}" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Hero title</label>
                    <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $cerc['hero_title'] ?? '') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Hero lead</label>
                    <textarea name="hero_lead" class="form-control" rows="3" required>{{ old('hero_lead', $cerc['hero_lead'] ?? '') }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Summary label</label>
                    <input type="text" name="summary_label" class="form-control" value="{{ old('summary_label', $cerc['summary_label'] ?? '') }}" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Summary text</label>
                    <textarea name="summary_copy" class="form-control" rows="3" required>{{ old('summary_copy', $cerc['summary_copy'] ?? '') }}</textarea>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Document section title</label>
                    <input type="text" name="document_section_title" class="form-control" value="{{ old('document_section_title', $cerc['document_section_title'] ?? '') }}" required>
                </div>
                <div class="col-md-7">
                    <label class="form-label">Document section description</label>
                    <textarea name="document_section_description" class="form-control" rows="3" required>{{ old('document_section_description', $cerc['document_section_description'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-3 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-green">Save page content</button>
                <a href="{{ route('cerc') }}" target="_blank" class="btn btn-outline-secondary">View CERC page</a>
            </div>
        </form>
    </div>

    <div class="card feature-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle irdc-admin-safeguard-table">
                <thead class="table-light">
                    <tr>
                        <th style="width:4rem">Order</th>
                        <th>Title & description</th>
                        <th style="width:11rem">Document file</th>
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
                                @if ($item->file_path)
                                    <span class="badge text-bg-primary">{{ $item->fileTypeLabel() }}</span>
                                    <div class="small text-muted text-truncate mt-1" style="max-width:10rem" title="{{ $item->file_original_name }}">
                                        {{ $item->file_original_name ?: 'Uploaded file' }}
                                    </div>
                                @else
                                    <span class="text-muted small">No file</span>
                                @endif
                            </td>
                            <td class="small text-muted">
                                {{ $item->file_date?->format('M j, Y') ?? '-' }}
                            </td>
                            <td>
                                <span class="badge text-bg-{{ $item->status === 'published' ? 'success' : 'secondary' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.cerc-documents.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.cerc-documents.destroy', $item) }}" onsubmit="return confirm('Remove this CERC document?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted p-4">
                                No CERC documents yet. <a href="{{ route('admin.cerc-documents.create') }}">Add the first one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
