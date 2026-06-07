{{-- 5. Krushi TV: modern media cards --}}
<section class="irdc-media-section irdc-reveal-on-scroll">
    <div class="container max-w-6xl">
        <header class="irdc-section-head !mb-10 sm:!mb-12">
            <p class="irdc-section-head__eyebrow">Krushi TV &amp; video</p>
            <h2 class="irdc-section-head__title">Field stories &amp; video</h2>
            <p class="irdc-section-head__lead">Modern updates from project areas, training sessions, and community engagement.</p>
        </header>

        @php
            $commonItems = [
                'On-the-ground activities and good agricultural practices in partner areas.',
                'Highlights of training, workshops, and engagement with communities.',
                'New videos are added on the YouTube channel as they are ready.',
            ];
            $mediaCards = $homeVideos->isNotEmpty()
                ? $homeVideos->sortBy('sort_order')->values()->map(function ($video) use ($commonItems): array {
                    return [
                        'title' => $video->title,
                        'items' => [
                            $video->bullet_one ?: $commonItems[0],
                            $video->bullet_two ?: $commonItems[1],
                            $video->bullet_three ?: $commonItems[2],
                        ],
                        'video_id' => $video->youtube_id,
                    ];
                })
                : $videoCards->values()->map(function (string $videoId, int $index) use ($commonItems): array {
                    return [
                        'title' => 'Video '.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                        'items' => $commonItems,
                        'video_id' => $videoId,
                    ];
                });
        @endphp

        @if($mediaCards->isNotEmpty())
            <div class="irdc-media-card-grid" data-reveal-stagger>
                @foreach($mediaCards as $card)
                <article class="irdc-media-feature-card">
                    <h3 class="irdc-media-feature-card__title">{{ $card['title'] }}</h3>
                    <ul class="irdc-media-feature-card__list">
                        @foreach($card['items'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>

                    @if(filled($card['video_id']))
                        <div class="irdc-media-feature-card__video">
                            <iframe
                                class="h-full w-full"
                                src="https://www.youtube.com/embed/{{ $card['video_id'] }}?rel=0"
                                title="{{ $card['title'] }} video"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen
                            ></iframe>
                        </div>
                    @else
                        <div class="irdc-media-feature-card__empty">Add YouTube video</div>
                    @endif

                    <a href="{{ $ytChannel }}" rel="noopener noreferrer" target="_blank" class="irdc-media-feature-card__cta">
                        Visit channel
                    </a>
                </article>
                @endforeach
            </div>
        @else
            <p class="irdc-empty-state">{{ __('messages.home_youtube_empty') }}</p>
        @endif
    </div>
</section>
