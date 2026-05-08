@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="section-title mb-1">Impact metrics</h2>
            <p class="text-muted mb-0">Edit the home page impact numbers shown under the agriculture project overview.</p>
        </div>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.impact-metrics.update') }}">
        @csrf
        @method('PUT')

        <div class="row g-4">
            @foreach($metrics as $metric)
                <div class="col-md-6">
                    <div class="card feature-card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                            <h3 class="h5 fw-bold mb-0">{{ $metric->label }}</h3>
                            <span class="badge text-bg-light border">{{ $metric->key }}</span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" name="metrics[{{ $metric->id }}][label]" class="form-control" value="{{ old("metrics.$metric->id.label", $metric->label) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Display value</label>
                            <input type="text" name="metrics[{{ $metric->id }}][value]" class="form-control" value="{{ old("metrics.$metric->id.value", $metric->value) }}" required>
                            <div class="form-text">Example: 57,500 or USD 105 Million.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Animated number target</label>
                            <input type="number" name="metrics[{{ $metric->id }}][count_target]" class="form-control" value="{{ old("metrics.$metric->id.count_target", $metric->count_target) }}" min="0">
                            <div class="form-text">Use only for plain numbers. Leave blank for values like USD 105 Million.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short note</label>
                            <input type="text" name="metrics[{{ $metric->id }}][helper]" class="form-control" value="{{ old("metrics.$metric->id.helper", $metric->helper) }}">
                        </div>

                        <div class="row g-3 align-items-end">
                            <div class="col-6">
                                <label class="form-label">Order</label>
                                <input type="number" name="metrics[{{ $metric->id }}][sort_order]" class="form-control" value="{{ old("metrics.$metric->id.sort_order", $metric->sort_order) }}" min="0" max="9999">
                            </div>
                            <div class="col-6">
                                <div class="form-check form-switch pb-2">
                                    <input type="hidden" name="metrics[{{ $metric->id }}][is_active]" value="0">
                                    <input class="form-check-input" type="checkbox" name="metrics[{{ $metric->id }}][is_active]" value="1" id="metric-active-{{ $metric->id }}" @checked(old("metrics.$metric->id.is_active", $metric->is_active))>
                                    <label class="form-check-label" for="metric-active-{{ $metric->id }}">Show</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-green">Save impact metrics</button>
            <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary">View home page</a>
        </div>
    </form>
</section>
@endsection
