@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit other announcement</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.other-announcements.update', $otherAnnouncement) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.other-announcements.partials.form', ['item' => $otherAnnouncement])
            <button type="submit" class="btn btn-green">Update</button>
            <a href="{{ route('admin.other-announcements.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
