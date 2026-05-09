@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit home video</h2>
    <div class="irdc-admin-form-card" style="max-width: 720px;">
        <form method="POST" action="{{ route('admin.home-videos.update', $homeVideo) }}">
            @csrf @method('PUT')
            @include('admin.home-videos.partials.form', ['item' => $homeVideo])
            <div class="mt-4">
                <button type="submit" class="btn btn-green">Save changes</button>
                <a href="{{ route('admin.home-videos.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>
        </form>
    </div>
</section>
@endsection

