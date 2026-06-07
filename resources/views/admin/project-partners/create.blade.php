@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add project partner</h2>
    <div class="irdc-admin-form-card" style="max-width: 760px;">
        @include('admin.project-partners.partials.form', [
            'action' => route('admin.project-partners.store'),
            'method' => 'POST',
            'partner' => null,
        ])
    </div>
</section>
@endsection
