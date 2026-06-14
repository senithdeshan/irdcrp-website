@props(['wide' => false])

@php
    use App\Support\ContactLocation;

    $location = ContactLocation::config();
    $locationImageUrl = ContactLocation::imageUrl();
    $mapEmbedUrl = ContactLocation::mapEmbedUrl();
    $mapsDirectionsUrl = ContactLocation::directionsUrl();
@endphp

<div @class([
    'irdc-contact-modern__top-card',
    'irdc-contact-modern__top-card--wide' => $wide,
])>
    <article @class([
        'irdc-contact-modern__location-card',
        'irdc-contact-modern__location-card--text-only' => blank($mapEmbedUrl),
    ])>
        <div class="irdc-contact-modern__location-body">
            <div class="irdc-contact-icon irdc-contact-icon--inline" aria-hidden="true">📍</div>
            <h2 class="irdc-contact-modern__hero-title">{{ $location['title'] ?? 'Our Location' }}</h2>
            <p class="irdc-contact-modern__hero-line">{{ $location['unit'] ?? 'Project Management Unit' }}</p>
            <p class="irdc-contact-modern__hero-line">{{ $location['project'] ?? 'Integrated Rurban Development and Climate Resilience Project (IRDCRP)' }}</p>
            <div class="irdc-contact-modern__address-block">
                <p>{{ ContactLocation::address() }}</p>
            </div>

            @if (filled($mapsDirectionsUrl))
                <a
                    href="{{ $mapsDirectionsUrl }}"
                    class="irdc-contact-modern__directions-btn"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Get Directions
                </a>
            @endif

            @if ($locationImageUrl)
                <figure class="irdc-contact-modern__location-photo">
                    <img
                        src="{{ $locationImageUrl }}"
                        alt="{{ $location['place_name'] ?? 'IRDCRP Project Management Unit' }} — office entrance at Battaramulla"
                        width="360"
                        height="220"
                        loading="lazy"
                        decoding="async"
                    >
                    @if (filled($location['image_caption'] ?? null))
                        <figcaption>{{ $location['image_caption'] }}</figcaption>
                    @endif
                </figure>
            @endif
        </div>

        @if (filled($mapEmbedUrl))
            <div class="irdc-contact-modern__location-map" aria-label="Map showing IRDCRP office location">
                <iframe
                    src="{{ $mapEmbedUrl }}"
                    title="{{ $location['title'] ?? 'Our Location' }} on Google Maps"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>
        @endif
    </article>
</div>
