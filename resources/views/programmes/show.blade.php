@extends('layouts.app')

@section('content')
<section class="irdc-programme-show">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 py-14 sm:px-6 sm:py-16 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:px-8">
        <div>
            <a href="{{ route('programmes.index') }}" class="irdc-programme-show__back">Back to programmes</a>
            <h1 class="irdc-programme-show__title">{{ $programme->title }}</h1>
            @if($programme->summary)
                <p class="irdc-programme-show__lead">{{ $programme->summary }}</p>
            @endif
        </div>
        <div class="irdc-programme-show__image">
            <img src="{{ str_starts_with($programme->image ?? '', 'images/') ? asset($programme->image) : asset('storage/'.$programme->image) }}" alt="{{ $programme->title }}">
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 sm:py-14 lg:px-8">
        <div class="prose max-w-none prose-slate">
            {!! nl2br(e($programme->description ?: $programme->summary)) !!}
        </div>
    </div>
</section>

@if($moreProgrammes->isNotEmpty())
    <section class="border-t border-slate-200 bg-slate-50 py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="font-display text-2xl font-extrabold text-[#0A3D62]">More programmes</h2>
            <div class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-3">
                @foreach($moreProgrammes as $item)
                    <a href="{{ route('programmes.show', $item) }}" class="irdc-programme-mini">
                        <img src="{{ str_starts_with($item->image ?? '', 'images/') ? asset($item->image) : asset('storage/'.$item->image) }}" alt="{{ $item->title }}">
                        <span>{{ $item->title }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
