@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1">Home page images</h2>
            <p class="text-muted mb-0">Change the seven hero slider images shown on the home page. Set a display period to schedule when each slide appears.</p>
        </div>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card feature-card p-4 mb-4">
        <h3 class="h5 fw-bold mb-1">Slider timing</h3>
        <p class="text-muted small mb-3">How long each hero slide stays visible before moving to the next one.</p>
        <form method="POST" action="{{ route('admin.home-images.slider-settings.update') }}" class="row g-3 align-items-end">
            @csrf
            @method('PUT')
            <div class="col-md-4">
                <label class="form-label" for="slide_interval_seconds">Seconds per slide</label>
                <input
                    type="number"
                    id="slide_interval_seconds"
                    name="slide_interval_seconds"
                    class="form-control"
                    min="3"
                    max="60"
                    value="{{ old('slide_interval_seconds', $sliderSettings['slide_interval_seconds'] ?? 10) }}"
                    required
                >
                <div class="form-text">Between 3 and 60 seconds. Default is 10 seconds.</div>
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-green">Save timing</button>
            </div>
        </form>
    </div>

    <div class="row g-4">
        @foreach($items as $item)
            <div class="col-md-6 col-xl-4">
                <div class="card feature-card h-100 overflow-hidden">
                    <img
                        src="{{ $item->imageUrl() }}"
                        alt="{{ $item->title }}"
                        class="w-100"
                        style="height: 180px; object-fit: cover;"
                    >
                    <div class="card-body">
                        <div class="d-flex justify-content-between gap-3">
                            <h3 class="h5 fw-bold mb-1">{{ $item->title }}</h3>
                            <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }} align-self-start">
                                {{ $item->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </div>
                        <p class="small text-muted mb-3">{{ \Illuminate\Support\Str::limit($item->caption, 100) }}</p>
                        <p class="small mb-2">
                            <span class="text-muted">Display period:</span>
                            {{ $item->scheduleLabel() }}
                        </p>
                        @php($scheduleStatus = $item->scheduleStatus())
                        <p class="small mb-3">
                            @if($scheduleStatus === 'live')
                                <span class="badge bg-success">Live on home page</span>
                            @elseif($scheduleStatus === 'always')
                                <span class="badge bg-success">Always on home page</span>
                            @elseif($scheduleStatus === 'scheduled')
                                <span class="badge bg-warning text-dark">Scheduled</span>
                            @elseif($scheduleStatus === 'expired')
                                <span class="badge bg-danger">Period ended</span>
                            @else
                                <span class="badge bg-secondary">Hidden</span>
                            @endif
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Slide {{ $item->sort_order }}</span>
                            <a href="{{ route('admin.home-images.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
