@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit gallery media</h2>
    <div class="card feature-card p-4" style="max-width: 760px;">
        @if($gallery->mediaUrl())
            <div class="mb-3 rounded border bg-light p-3">
                <p class="small fw-bold text-muted mb-2">Current media</p>
                @if($gallery->media_type === 'image')
                    <img src="{{ $gallery->mediaUrl() }}" alt="" class="img-fluid rounded" style="max-height: 220px;">
                @elseif($gallery->media_type === 'audio')
                    <audio controls class="w-100" src="{{ $gallery->mediaUrl() }}"></audio>
                @elseif($gallery->media_type === 'video' && ! $gallery->external_url)
                    <video controls class="w-100 rounded" style="max-height: 260px;" src="{{ $gallery->mediaUrl() }}"></video>
                @else
                    <a href="{{ $gallery->mediaUrl() }}" target="_blank" rel="noopener">{{ $gallery->mediaUrl() }}</a>
                @endif
            </div>
        @endif

        <form method="POST" action="{{ route('admin.gallery.update', $gallery) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.gallery.partials.form', ['gallery' => $gallery])
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">Back</a>
        </form>
    </div>
</section>
@endsection
