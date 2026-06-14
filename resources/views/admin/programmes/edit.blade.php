@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit programme</h2>
    <div class="card feature-card p-4" style="max-width: 820px;">
        <form method="POST" action="{{ route('admin.programmes.update', $programme) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.programmes.partials.form', ['programme' => $programme, 'components' => $components])
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.programmes.index') }}" class="btn btn-outline-secondary">Back</a>
        </form>
    </div>
</section>
@endsection
