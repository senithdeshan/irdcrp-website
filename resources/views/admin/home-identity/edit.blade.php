@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="section-title mb-1">Project identity</h1>
            <p class="text-muted mb-0">Edit the Project Identity section shown on the home page.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ url('/#about-project') }}" target="_blank" class="btn btn-outline-secondary">Preview section</a>
            <a href="{{ route('admin.home-layout.edit') }}" class="btn btn-outline-secondary">Home layout</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="irdc-admin-form-card" style="max-width: 980px;">
        <form method="POST" action="{{ route('admin.home-identity.update') }}">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-5">
                    <label for="eyebrow" class="form-label">Eyebrow label</label>
                    <input
                        id="eyebrow"
                        type="text"
                        name="eyebrow"
                        class="form-control"
                        value="{{ old('eyebrow', $identity['eyebrow'] ?? '') }}"
                        required
                    >
                </div>

                <div class="col-md-7">
                    <label for="title" class="form-label">Main title</label>
                    <input
                        id="title"
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title', $identity['title'] ?? '') }}"
                        required
                    >
                </div>

                <div class="col-12">
                    <label for="paragraphs" class="form-label">Introduction paragraphs</label>
                    <textarea
                        id="paragraphs"
                        name="paragraphs"
                        rows="9"
                        class="form-control"
                        required
                    >{{ old('paragraphs', implode("\n\n", $identity['paragraphs'] ?? [])) }}</textarea>
                    <div class="form-text">Add each paragraph on a separate line. Blank lines are ignored.</div>
                </div>

                <div class="col-12">
                    <label for="badges" class="form-label">Focus badges</label>
                    <textarea
                        id="badges"
                        name="badges"
                        rows="3"
                        class="form-control"
                    >{{ old('badges', implode("\n", $identity['badges'] ?? [])) }}</textarea>
                    <div class="form-text">One badge per line.</div>
                </div>

                <div class="col-12">
                    <h2 class="h5 mb-3">Project names</h2>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="name_si" class="form-label">Sinhala name</label>
                            <textarea id="name_si" name="names[si]" rows="4" class="form-control">{{ old('names.si', $identity['names']['si'] ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="name_ta" class="form-label">Tamil name</label>
                            <textarea id="name_ta" name="names[ta]" rows="4" class="form-control">{{ old('names.ta', $identity['names']['ta'] ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="name_en" class="form-label">English name</label>
                            <textarea id="name_en" name="names[en]" rows="4" class="form-control" required>{{ old('names.en', $identity['names']['en'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-green">Save project identity</button>
                <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
            </div>
        </form>
    </div>
</section>
@endsection
