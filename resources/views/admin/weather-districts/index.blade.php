@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="section-title mb-1">Weather widget</h2>
            <p class="text-muted mb-0">Manage the home page Live forecasts image and district list for weather data.</p>
        </div>
        <a href="{{ route('admin.weather-districts.create') }}" class="btn btn-green">Add district</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card feature-card p-4 mb-4">
        <h3 class="h6 fw-bold mb-3">Section image</h3>
        <p class="small text-muted">Shown on the left side of the weather card on the home page. District-specific images override this when set.</p>
        <div class="row g-4 align-items-start">
            <div class="col-md-4">
                <img src="{{ $defaultImageUrl }}" alt="Weather section image" class="img-fluid rounded border" style="max-height: 280px; object-fit: cover; width: 100%;">
            </div>
            <div class="col-md-8">
                <form method="POST" action="{{ route('admin.weather-districts.settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <label class="form-label">Replace image</label>
                    <input type="file" name="default_image" class="form-control" accept="image/jpeg,image/png,image/webp">
                    <p class="small text-muted mt-2 mb-3">JPG or PNG, max 8 MB. Portrait photos work best.</p>
                    <button type="submit" class="btn btn-green btn-sm">Update image</button>
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered bg-white align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order</th>
                    <th>District</th>
                    <th>Coordinates</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->sort_order }}</td>
                        <td>
                            <strong>{{ $item->name_en }}</strong>
                            @if($item->name_si || $item->name_ta)
                                <div class="small text-muted">
                                    @if($item->name_si) {{ $item->name_si }} @endif
                                    @if($item->name_ta) · {{ $item->name_ta }} @endif
                                </div>
                            @endif
                        </td>
                        <td class="small">{{ $item->latitude }}, {{ $item->longitude }}</td>
                        <td>
                            <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $item->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.weather-districts.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form class="d-inline" method="POST" action="{{ route('admin.weather-districts.destroy', $item) }}" onsubmit="return confirm('Remove this district?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted p-4">No districts yet. Add districts to show weather forecasts on the home page.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
