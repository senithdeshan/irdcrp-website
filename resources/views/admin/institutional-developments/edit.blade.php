@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit Capacity Build item</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.institutional-developments.update', $item) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.institutional-developments.partials.form', ['item' => $item])
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.institutional-developments.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
