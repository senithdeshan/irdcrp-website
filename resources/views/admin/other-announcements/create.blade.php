@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add other announcement</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.other-announcements.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.other-announcements.partials.form')
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.other-announcements.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
