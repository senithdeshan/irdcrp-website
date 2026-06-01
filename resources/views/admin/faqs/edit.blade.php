@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit FAQ</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
            @csrf
            @method('PUT')

            @include('admin.faqs.partials.form', ['faq' => $faq])

            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">Back</a>
        </form>
    </div>
</section>
@endsection
