@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">{{ $news->title_en }}</h1>
        <p class="lead mb-0">{{ $news->published_date }}</p>
    </div>
</section>

<section class="container py-5">
    <div class="card feature-card p-4">
        @if($news->image)
            <img src="{{ asset('storage/'.$news->image) }}" class="img-fluid rounded mb-4">
        @endif

        <p style="white-space: pre-line;">{{ $news->content_en }}</p>

        <a href="/news" class="btn btn-green mt-3">Back to News</a>
    </div>
</section>

@endsection