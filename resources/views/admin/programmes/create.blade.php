@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add programme</h2>
    <div class="card feature-card p-4" style="max-width: 820px;">
        <form method="POST" action="{{ route('admin.programmes.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.programmes.partials.form', ['programme' => null, 'components' => $components])
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.programmes.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
