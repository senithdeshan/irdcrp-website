@props(['wide' => false])

@php
    $location = config('irdcrp.contact.location', []);
    $locationImage = $location['image'] ?? null;
    $hasLocationImage = filled($locationImage) && file_exists(public_path(ltrim($locationImage, '/')));
    $mapLat = $location['latitude'] ?? null;
    $mapLng = $location['longitude'] ?? null;
    $mapZoom = (int) ($location['map_zoom'] ?? 19);
    $mapEmbedUrl = filled($mapLat) && filled($mapLng)
        ? sprintf(
            'https://www.google.com/maps?q=%s,%s&hl=en&z=%d&t=h&output=embed',
            $mapLat,
            $mapLng,
            $mapZoom
        )
        : ($location['map_embed_url'] ?? config('irdcrp.map_embed_url'));
    $mapsDirectionsUrl = $location['maps_url']
        ?? (filled($mapLat) && filled($mapLng)
            ? sprintf('https://www.google.com/maps/dir/?api=1&destination=%s,%s', $mapLat, $mapLng)
            : null);
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
                <p>{{ config('irdcrp.contact.address') }}</p>
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

            @if ($hasLocationImage)
                <figure class="irdc-contact-modern__location-photo">
                    <img
                        src="{{ asset(ltrim($locationImage, '/')) }}"
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
