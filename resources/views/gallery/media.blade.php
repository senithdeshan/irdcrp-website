@extends('layouts.app')

@section('content')
    @include('gallery.partials.subnav')

    <section class="border-b border-stone-200/90 bg-gradient-to-b from-stone-50 to-white">
        <div class="mx-auto max-w-6xl px-4 py-10 text-center sm:py-14">
            <h1 class="font-display text-3xl font-extrabold leading-tight tracking-tight text-slate-800 sm:text-4xl md:text-[2.4rem]">
                <span class="text-slate-800">IRDCRP</span>
                <span class="text-[#6B2B27]"> {{ __($titleKey) }}</span>
            </h1>
            <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-500 sm:text-base">
                Browse media updates uploaded by the project team.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 sm:py-14">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse($items as $item)
                @php($url = $item->mediaUrl())
                <article class="overflow-hidden rounded-2xl border border-stone-200/80 bg-white shadow-sm ring-1 ring-stone-900/[0.03] transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex aspect-video items-center justify-center bg-gradient-to-br from-emerald-50 via-white to-slate-50 p-4">
                        @if($item->media_type === 'audio' && $url)
                            <div class="w-full">
                                <div class="mb-4 text-center text-4xl font-extrabold text-emerald-700">Audio</div>
                                <audio controls class="w-full" src="{{ $url }}"></audio>
                            </div>
                        @elseif($item->media_type === 'video' && $url && ! $item->external_url)
                            <video controls class="h-full w-full rounded-xl object-cover" src="{{ $url }}"></video>
                        @elseif($item->media_type === 'image' && $url)
                            <img src="{{ $url }}" alt="{{ $item->title }}" class="h-full w-full rounded-xl object-cover">
                        @elseif($item->media_type === 'document')
                            <div class="text-center">
                                <div class="text-4xl font-extrabold text-[#0A3D62]">PDF</div>
                                <p class="mt-2 text-sm font-semibold text-slate-500">Presentation document</p>
                            </div>
                        @else
                            <div class="text-center">
                                <div class="text-4xl font-extrabold text-emerald-700">Link</div>
                                <p class="mt-2 text-sm font-semibold text-slate-500">{{ $item->mediaTypeLabel() }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="mb-2 flex flex-wrap gap-2">
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-800">{{ $item->categoryLabel() }}</span>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $item->mediaTypeLabel() }}</span>
                            @if($item->is_pinned)
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-900">Pinned</span>
                            @endif
                        </div>
                        <h2 class="font-display text-lg font-extrabold text-slate-900">{{ $item->title }}</h2>
                        @if($item->item_date)
                            <p class="mt-1 text-xs text-slate-500">{{ $item->item_date->format('M j, Y') }}</p>
                        @endif
                        @if($item->description)
                            <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-600">{{ $item->description }}</p>
                        @endif
                        @if($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" class="mt-4 inline-flex rounded-full bg-emerald-700 px-4 py-2 text-sm font-bold text-white transition hover:bg-emerald-800">
                                Open media
                            </a>
                        @endif
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-stone-300 bg-stone-50/80 px-6 py-14 text-center md:col-span-2 lg:col-span-3">
                    <p class="text-slate-600">No media has been added to this category yet.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
