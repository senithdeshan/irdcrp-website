@extends('layouts.app')

@section('content')

<section class="py-4 border-bottom">
    <div class="container">
        <h1 class="h2 fw-bold text-dark">{{ $page->title }}</h1>
    </div>
</section>

<section class="container py-5">
    <article class="cms-content mx-auto" style="max-width: 720px;">
        {!! $page->content !!}
    </article>
</section>

@endsection
