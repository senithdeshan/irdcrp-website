@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-3">
        <p class="mb-0"><a href="{{ route('vacancies.index') }}" class="text-white-50 text-decoration-none">← {{ __('messages.nav_vacancies') }}</a></p>
        <h1 class="fw-bold mt-2">{{ $vacancy->title }}</h1>
        <p class="mb-0">
            Deadline: <strong>{{ $vacancy->deadline->format('F j, Y') }}</strong>
            @if($vacancy->status === 'open' && $vacancy->isOpenForPublic())
                <span class="badge text-bg-light text-dark ms-2">Open</span>
            @else
                <span class="badge text-bg-warning text-dark ms-2">Closed / passed</span>
            @endif
        </p>
    </div>
</section>

<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card feature-card p-4 mb-4">
                <div class="prose" style="white-space: pre-wrap;">{!! nl2br(e($vacancy->description)) !!}</div>
            </div>
            <p>
                <a class="btn btn-danger" href="{{ route('vacancies.file', $vacancy) }}">Download notice (PDF)</a>
            </p>
        </div>
    </div>
</section>

@endsection
