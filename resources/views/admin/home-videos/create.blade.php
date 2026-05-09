@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add home video</h2>
    <div class="irdc-admin-form-card" style="max-width: 720px;">
        <form method="POST" action="{{ route('admin.home-videos.store') }}">
            @csrf
            @include('admin.home-videos.partials.form')
            <div class="mt-4">
                <button type="submit" class="btn btn-green">Save video</button>
                <a href="{{ route('admin.home-videos.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</section>
@endsection

