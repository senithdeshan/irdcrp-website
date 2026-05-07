@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">Support Message</h2>
        <a href="{{ route('admin.support-messages.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
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
        <p class="mb-1"><strong>Name:</strong> {{ $supportMessage->name }}</p>
        <p class="mb-1"><strong>Email:</strong> {{ $supportMessage->email }}</p>
        @if($supportMessage->phone)
            <p class="mb-1"><strong>Phone:</strong> {{ $supportMessage->phone }}</p>
        @endif
        <p class="mb-1"><strong>Subject:</strong> {{ $supportMessage->subject }}</p>
        <p class="mb-1"><strong>Date:</strong> {{ $supportMessage->created_at->format('Y-m-d H:i') }}</p>
        <div class="mt-3 rounded bg-light p-3">{{ $supportMessage->message }}</div>
    </div>

    <div class="card feature-card p-4">
        <h3 class="h5 fw-bold mb-3">Process & Reply</h3>
        <form method="POST" action="{{ route('admin.support-messages.update', $supportMessage) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="new" @selected(old('status', $supportMessage->status) === 'new')>New</option>
                    <option value="in_progress" @selected(old('status', $supportMessage->status) === 'in_progress')>In Progress</option>
                    <option value="resolved" @selected(old('status', $supportMessage->status) === 'resolved')>Resolved</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Answer to User</label>
                <textarea name="admin_reply" rows="5" class="form-control">{{ old('admin_reply', $supportMessage->admin_reply) }}</textarea>
            </div>

            @if($supportMessage->resolved_at)
                <p class="small text-muted">Resolved at: {{ $supportMessage->resolved_at->format('Y-m-d H:i') }}</p>
            @endif

            <button class="btn btn-green">Save Update</button>
        </form>
    </div>
</section>
@endsection
