@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit document</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.downloads.update', $download) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.downloads.partials.form', ['download' => $download])
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.downloads.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
