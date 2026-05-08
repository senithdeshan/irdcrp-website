@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add gallery media</h2>
    <div class="card feature-card p-4" style="max-width: 760px;">
        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.gallery.partials.form', ['gallery' => null])
            <button type="submit" class="btn btn-green">Save media</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
