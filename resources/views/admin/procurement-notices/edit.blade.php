@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit procurement notice</h2>

    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.procurement-notices.update', $notice) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.procurement-notices.partials.form', ['notice' => $notice])
        </form>
    </div>
</section>
@endsection
