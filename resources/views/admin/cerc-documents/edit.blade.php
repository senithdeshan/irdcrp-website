@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit CERC document</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.cerc-documents.update', $cercDocument) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.cerc-documents.partials.form', ['cercDocument' => $cercDocument])
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.cerc-documents.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
