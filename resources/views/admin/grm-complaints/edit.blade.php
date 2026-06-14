@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">GRM Complaint</h2>
        <a href="{{ route('admin.grm-complaints.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card feature-card p-4 mb-4">
        <h3 class="h5 fw-bold mb-3">Submitted Message</h3>
        <p class="mb-1"><strong>Name:</strong> {{ $grmComplaint->name }}</p>
        <p class="mb-1"><strong>Email:</strong> {{ $grmComplaint->email }}</p>
        <p class="mb-1"><strong>Date:</strong> {{ $grmComplaint->created_at->format('Y-m-d H:i') }}</p>
        <div class="mt-3 rounded bg-light p-3">{{ $grmComplaint->message }}</div>
    </div>

    <div class="card feature-card p-4">
        <h3 class="h5 fw-bold mb-3">Update status</h3>
        <form method="POST" action="{{ route('admin.grm-complaints.update', $grmComplaint) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="new" @selected(old('status', $grmComplaint->status) === 'new')>Unsolved</option>
                    <option value="in_progress" @selected(old('status', $grmComplaint->status) === 'in_progress')>In Progress</option>
                    <option value="solved" @selected(old('status', $grmComplaint->status) === 'solved')>Solved</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Admin notes <span class="text-muted fw-normal">(optional)</span></label>
                <textarea name="admin_reply" rows="5" class="form-control" placeholder="Internal notes or reply details for this complaint">{{ old('admin_reply', $grmComplaint->admin_reply) }}</textarea>
            </div>

            @if($grmComplaint->resolved_at)
                <p class="small text-muted">Resolved at: {{ $grmComplaint->resolved_at->format('Y-m-d H:i') }}</p>
            @endif

            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-green">Save Update</button>
            </div>
        </form>
    </div>

    <div class="card feature-card p-4 mt-4 border-danger">
        <h3 class="h5 fw-bold mb-2 text-danger">Delete complaint</h3>
        <p class="small text-muted mb-3">Remove this grievance permanently from the admin panel and public GRM statistics.</p>
        <form method="POST" action="{{ route('admin.grm-complaints.destroy', $grmComplaint) }}" onsubmit="return confirm('Delete this GRM complaint permanently?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">Delete complaint</button>
        </form>
    </div>
</section>
@endsection
