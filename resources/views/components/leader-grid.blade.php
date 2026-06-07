@props([
    'leaders',
    'staff' => false,
])

@php
    $tLoc = in_array(app()->getLocale(), ['en', 'si', 'ta'], true) ? app()->getLocale() : 'en';
@endphp

<div @class([
    'irdc-leaders-grid',
    'irdc-leaders-grid--staff' => $staff,
])>
    @foreach ($leaders as $leader)
        @php
            if ($leader instanceof \App\Models\KeyLeader) {
                $portrait = $leader->image
                    ? asset('storage/'.$leader->image)
                    : asset('images/hero/hero-home-02.png');
                $roleLabel = $leader->label('role', $tLoc);
                $orgLabel = $leader->label('org', $tLoc);
            } else {
                $imgPath = ltrim($leader['image'] ?? '', '/');
                $portraitPath = isset($leader['image']) && is_file(public_path($imgPath))
                    ? $leader['image']
                    : ($leader['fallback'] ?? '/images/hero/hero-home-01.png');
                $portrait = str_starts_with($portraitPath, 'http')
                    ? $portraitPath
                    : asset(ltrim($portraitPath, '/'));
                $roleKey = $leader['role'] ?? '';
                $orgKey = $leader['org'] ?? '';
                $roleLabel = $roleKey ? __('messages.'.$roleKey) : '';
                $orgLabel = $orgKey ? __('messages.'.$orgKey) : '';
            }
        @endphp
        <article class="irdc-leader-card">
            <span class="irdc-leader-card__index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
            <div class="irdc-leader-card__photo">
                <img
                    src="{{ $portrait }}"
                    alt="{{ __('messages.leader_photo_alt', ['role' => $roleLabel]) }}"
                    width="280"
                    height="280"
                    loading="lazy"
                    decoding="async"
                    class="irdc-leader-card__img"
                >
            </div>
            <div class="irdc-leader-card__content">
                @if(filled($roleLabel))
                    <h3 class="irdc-leader-card__role">{{ $roleLabel }}</h3>
                @endif
                @if(filled($orgLabel))
                    <p class="irdc-leader-card__org">{{ $orgLabel }}</p>
                @endif
            </div>
        </article>
    @endforeach
</div>
