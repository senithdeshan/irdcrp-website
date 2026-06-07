@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit project partner</h2>
    <div class="irdc-admin-form-card" style="max-width: 760px;">
        <div class="mb-3 p-3 bg-light rounded text-center">
            <img src="{{ $projectPartner->logoUrl() }}" alt="{{ $projectPartner->name }}" class="img-fluid" style="max-height: 80px; object-fit: contain;">
        </div>
        @include('admin.project-partners.partials.form', [
            'action' => route('admin.project-partners.update', $projectPartner),
            'method' => 'PUT',
            'partner' => $projectPartner,
        ])
    </div>
</section>
@endsection
