@extends('layouts.app')

@section('content')

<section class="container py-5">
    <h2 class="section-title mb-4">Add News</h2>

    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Title EN</label>
                <input type="text" name="title_en" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Content EN</label>
                <textarea name="content_en" class="form-control" rows="5" required></textarea>
            </div>

            <div class="mb-3">
                <label>Title SI</label>
                <input type="text" name="title_si" class="form-control">
            </div>

            <div class="mb-3">
                <label>Content SI</label>
                <textarea name="content_si" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label>Title TA</label>
                <input type="text" name="title_ta" class="form-control">
            </div>

            <div class="mb-3">
                <label>Content TA</label>
                <textarea name="content_ta" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label>Published Date</label>
                <input type="date" name="published_date" class="form-control">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>

            <button type="submit" class="btn btn-green">Save News</button>
        </form>
    </div>
</section>

@endsection