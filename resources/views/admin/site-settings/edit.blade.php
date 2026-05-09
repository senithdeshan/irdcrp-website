@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="section-title mb-1">Site settings</h1>
            <p class="text-muted mb-0">Update public social media channel links used in the header, home page rail, and footer.</p>
        </div>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please check the links.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.site-settings.update') }}">
        @csrf
        @method('PUT')

        <div class="card feature-card p-4">
            <h2 class="h5 fw-bold mb-3">Social channel links</h2>

            <div class="row g-4">
                @foreach($socialKeys as $key)
                    <div class="col-md-6">
                        <label for="social-{{ $key }}" class="form-label text-capitalize">{{ $key }}</label>
                        <input
                            id="social-{{ $key }}"
                            type="url"
                            name="social[{{ $key }}]"
                            class="form-control"
                            value="{{ old("social.$key", $socialLinks[$key] ?? '') }}"
                            placeholder="https://..."
                        >
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-green">Save social links</button>
                <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary">View home page</a>
            </div>
        </div>
    </form>
</section>
@endsection
