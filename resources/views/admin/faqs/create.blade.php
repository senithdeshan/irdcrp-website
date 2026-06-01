@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add FAQ</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.faqs.store') }}">
            @csrf

            @include('admin.faqs.partials.form', ['faq' => null])

            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
