@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit Safeguard item</h2>
    <p class="text-muted">{{ $safeguard->categoryLabel() }}</p>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.safeguards.update', $safeguard) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.safeguards.partials.form', ['safeguard' => $safeguard, 'categories' => $categories])
            <button type="submit" class="btn btn-green">Update</button>
            <a href="{{ route('admin.safeguards.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
