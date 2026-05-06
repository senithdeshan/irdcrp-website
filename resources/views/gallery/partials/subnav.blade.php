@php
    $sections = [
        'audio' => __('messages.nav_media_audio'),
        'photos' => __('messages.nav_media_photos'),
        'videos' => __('messages.nav_media_videos'),
        'presentation' => __('messages.nav_media_presentation'),
        'voice' => __('messages.nav_media_voice'),
    ];
    $current = request()->route('section');
@endphp
<nav class="border-b border-stone-200 bg-white" aria-label="{{ __('messages.nav_media_subnav_aria') }}">
    <div class="mx-auto flex w-full max-w-6xl flex-wrap justify-center gap-2 px-4 py-3">
        @foreach ($sections as $slug => $label)
            <a
                href="{{ route('gallery.section', $slug) }}"
                @class([
                    'rounded-full px-3 py-1.5 text-sm font-semibold transition',
                    'bg-emerald-800 text-white shadow-sm' => $current === $slug,
                    'bg-stone-100 text-slate-700 hover:bg-stone-200' => $current !== $slug,
                ])
            >{{ $label }}</a>
        @endforeach
    </div>
</nav>
