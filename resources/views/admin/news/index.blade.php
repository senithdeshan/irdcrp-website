@extends('layouts.app')

@section('content')

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Manage News</h2>
        <a href="{{ route('admin.news.create') }}" class="btn btn-green">Add News</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card feature-card p-4">
        <table class="table table-hover">
            <thead class="table-success">
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($news as $item)
                    <tr>
                        <td>{{ $item->title_en }}</td>
                        <td>{{ $item->published_date }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>
    <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>

    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this news?')">Delete</button>
    </form>
</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection