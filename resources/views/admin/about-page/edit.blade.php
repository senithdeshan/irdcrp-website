@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="section-title mb-1">About Us page</h1>
            <p class="text-muted mb-0">Edit the public About Us page under The Project. Save as draft to keep changes hidden until you publish.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ url('/about') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">View page</a>
            <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.about-page.update') }}">
        @csrf
        @method('PUT')

        <div class="card feature-card p-4 mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <h2 class="h5 fw-bold mb-3">Page header</h2>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="published" @selected(old('status', $about['status'] ?? 'published') === 'published')>Published</option>
                        <option value="draft" @selected(old('status', $about['status'] ?? '') === 'draft')>Draft</option>
                    </select>
                    @error('status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <div class="form-text">Draft keeps the current default text on the public site.</div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Page title</label>
                <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $about['hero_title'] ?? '') }}" required>
                @error('hero_title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-0">
                <label class="form-label">Subtitle</label>
                <input type="text" name="hero_subtitle" class="form-control" value="{{ old('hero_subtitle', $about['hero_subtitle'] ?? '') }}" required>
                @error('hero_subtitle')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card feature-card p-4 h-100">
                    <h2 class="h5 fw-bold mb-3">Our Mission</h2>
                    <div class="mb-3">
                        <label class="form-label">Heading</label>
                        <input type="text" name="mission_title" class="form-control" value="{{ old('mission_title', $about['mission_title'] ?? '') }}" required>
                        @error('mission_title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Text</label>
                        <textarea name="mission_text" class="form-control" rows="5" required>{{ old('mission_text', $about['mission_text'] ?? '') }}</textarea>
                        @error('mission_text')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card feature-card p-4 h-100">
                    <h2 class="h5 fw-bold mb-3">Our Objectives</h2>
                    <div class="mb-3">
                        <label class="form-label">Heading</label>
                        <input type="text" name="objectives_title" class="form-control" value="{{ old('objectives_title', $about['objectives_title'] ?? '') }}" required>
                        @error('objectives_title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Text</label>
                        <textarea name="objectives_text" class="form-control" rows="5" required>{{ old('objectives_text', $about['objectives_text'] ?? '') }}</textarea>
                        @error('objectives_text')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card feature-card p-4 mb-4">
            <h2 class="h5 fw-bold mb-3">Conflicts Mediation &amp; Grievance Redressal</h2>
            <div class="mb-3">
                <label class="form-label">Section heading</label>
                <input type="text" name="grievance_heading" class="form-control" value="{{ old('grievance_heading', $about['grievance_heading'] ?? '') }}" required>
                @error('grievance_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label">Intro text</label>
                <textarea name="grievance_lead" class="form-control" rows="3" required>{{ old('grievance_lead', $about['grievance_lead'] ?? '') }}</textarea>
                @error('grievance_lead')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3">
                @foreach (old('grievance_cards', $about['grievance_cards'] ?? []) as $index => $card)
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 bg-light h-100">
                            <p class="small fw-semibold text-muted mb-2">Card {{ $index + 1 }}</p>
                            <div class="mb-2">
                                <label class="form-label">Title</label>
                                <input type="text" name="grievance_cards[{{ $index }}][title]" class="form-control" value="{{ old("grievance_cards.$index.title", $card['title'] ?? '') }}" required>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Text</label>
                                <textarea name="grievance_cards[{{ $index }}][text]" class="form-control" rows="3" required>{{ old("grievance_cards.$index.text", $card['text'] ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @error('grievance_cards')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            @error('grievance_cards.*.title')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            @error('grievance_cards.*.text')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
        </div>

        <div class="card feature-card p-4 mb-4">
            <h2 class="h5 fw-bold mb-3">Why Choose Us?</h2>
            <div class="mb-4">
                <label class="form-label">Section heading</label>
                <input type="text" name="why_heading" class="form-control" value="{{ old('why_heading', $about['why_heading'] ?? '') }}" required>
                @error('why_heading')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3">
                @foreach (old('why_cards', $about['why_cards'] ?? []) as $index => $card)
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 bg-light h-100">
                            <p class="small fw-semibold text-muted mb-2">Card {{ $index + 1 }}</p>
                            <div class="mb-2">
                                <label class="form-label">Title</label>
                                <input type="text" name="why_cards[{{ $index }}][title]" class="form-control" value="{{ old("why_cards.$index.title", $card['title'] ?? '') }}" required>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Text</label>
                                <textarea name="why_cards[{{ $index }}][text]" class="form-control" rows="3" required>{{ old("why_cards.$index.text", $card['text'] ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @error('why_cards')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            @error('why_cards.*.title')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            @error('why_cards.*.text')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-green">Save About Us page</button>
    </form>
</section>
@endsection
