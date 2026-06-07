{{-- 7. Gallery preview --}}
<section class="irdc-gallery-section irdc-reveal-on-scroll">
    <div class="container max-w-6xl">
        <header class="irdc-section-head irdc-section-head--emerald">
            <p class="irdc-section-head__eyebrow">{{ __('messages.home_gallery_eyebrow') }}</p>
            <h2 class="irdc-section-head__title">{{ __('messages.home_gallery_title') }}</h2>
            <p class="irdc-section-head__lead">{{ __('messages.home_gallery_sub') }}</p>
        </header>
        @if($galleryPreview->isNotEmpty())
            <div class="irdc-gallery-grid">
                @foreach($galleryPreview->take(6) as $g)
                    <a href="{{ route('gallery.section', 'photos') }}" class="irdc-gallery-tile group">
                        <img
                            src="{{ $g->mediaUrl() }}"
                            alt="{{ $g->title }}"
                            loading="lazy"
                            decoding="async"
                        >
                        <span>{{ $g->title }}</span>
                    </a>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('gallery.section', 'photos') }}" class="irdc-button irdc-button--green">{{ __('messages.home_gallery_all') }}</a>
            </div>
        @else
            <p class="irdc-empty-state">{{ __('messages.home_gallery_empty') }}</p>
        @endif
    </div>
</section>
