@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Pages (CMS)</h2>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-green">Add page</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card feature-card p-0 overflow-hidden">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Title</th><th>Slug (URL)</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($pages as $p)
                <tr>
                    <td>{{ $p->title }}</td>
                    <td><a href="{{ route('page.show', $p) }}" target="_blank">/p/{{ $p->slug }}</a></td>
                    <td>{{ $p->status }}</td>
                    <td>
                        <a href="{{ route('admin.pages.edit', $p) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form class="d-inline" method="POST" action="{{ route('admin.pages.destroy', $p) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-muted">No pages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
