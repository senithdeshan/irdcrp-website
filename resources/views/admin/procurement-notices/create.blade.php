@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add procurement notice</h2>

    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.procurement-notices.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.procurement-notices.partials.form', ['notice' => null])
        </form>
    </div>
</section>
@endsection
