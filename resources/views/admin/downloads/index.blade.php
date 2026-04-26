@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Downloads</h2>
        <a href="{{ route('admin.downloads.create') }}" class="btn btn-green">Add file</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card feature-card p-0 overflow-hidden">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Title</th><th>Status</th><th>Order</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($items as $d)
                <tr>
                    <td>{{ $d->title }}</td>
                    <td>{{ $d->status }}</td>
                    <td>{{ $d->sort_order }}</td>
                    <td>
                        <a href="{{ route('admin.downloads.edit', $d) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form class="d-inline" method="POST" action="{{ route('admin.downloads.destroy', $d) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
