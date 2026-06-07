@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit report</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.reports.update', $report) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.reports.partials.form', ['report' => $report])
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
