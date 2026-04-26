@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Vacancies</h2>
        <a href="{{ route('admin.vacancies.create') }}" class="btn btn-green">Add vacancy</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card feature-card p-0 overflow-hidden">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Title</th><th>Deadline</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @foreach($items as $v)
                <tr>
                    <td>{{ $v->title }}</td>
                    <td>{{ $v->deadline->format('Y-m-d') }}</td>
                    <td>{{ $v->status }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.vacancies.edit', $v) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form class="d-inline" method="POST" action="{{ route('admin.vacancies.destroy', $v) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
