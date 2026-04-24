@extends('layouts.app')

@section('content')

<section class="container py-5">
    <h2 class="section-title mb-4">Edit News</h2>

    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.news.update', $news->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Title EN</label>
                <input type="text" name="title_en" class="form-control" value="{{ $news->title_en }}" required>
            </div>

            <div class="mb-3">
                <label>Content EN</label>
                <textarea name="content_en" class="form-control" rows="5" required>{{ $news->content_en }}</textarea>
            </div>

            <div class="mb-3">
                <label>Title SI</label>
                <input type="text" name="title_si" class="form-control" value="{{ $news->title_si }}">
            </div>

            <div class="mb-3">
                <label>Content SI</label>
                <textarea name="content_si" class="form-control" rows="4">{{ $news->content_si }}</textarea>
            </div>

            <div class="mb-3">
                <label>Title TA</label>
                <input type="text" name="title_ta" class="form-control" value="{{ $news->title_ta }}">
            </div>

            <div class="mb-3">
                <label>Content TA</label>
                <textarea name="content_ta" class="form-control" rows="4">{{ $news->content_ta }}</textarea>
            </div>

            <div class="mb-3">
                <label>Published Date</label>
                <input type="date" name="published_date" class="form-control" value="{{ $news->published_date }}">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="draft" {{ $news->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $news->status == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <button type="submit" class="btn btn-green">Update News</button>
        </form>
    </div>
</section>

@endsection