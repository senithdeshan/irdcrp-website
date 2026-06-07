@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add weather district</h2>
    <div class="irdc-admin-form-card" style="max-width: 760px;">
        @include('admin.weather-districts.partials.form', [
            'action' => route('admin.weather-districts.store'),
            'method' => 'POST',
            'district' => null,
        ])
    </div>
</section>
@endsection
