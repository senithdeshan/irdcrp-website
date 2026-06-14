@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit district area</h2>
    <div class="irdc-admin-form-card" style="max-width: 760px;">
        @include('admin.project-area-districts.partials.form', [
            'action' => route('admin.project-area-districts.update', $district),
            'method' => 'PUT',
            'district' => $district,
        ])
    </div>
</section>
@endsection
