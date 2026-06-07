@php
    $location = config('irdcrp.contact.location', []);
    $locationImage = $location['image'] ?? null;
    $hasLocationImage = filled($locationImage) && file_exists(public_path(ltrim($locationImage, '/')));
    $mapLat = $location['latitude'] ?? null;
    $mapLng = $location['longitude'] ?? null;
    $mapsDirectionsUrl = $location['maps_url']
        ?? (filled($mapLat) && filled($mapLng)
            ? sprintf('https://www.google.com/maps/dir/?api=1&destination=%s,%s', $mapLat, $mapLng)
            : null);
    $placeName = $location['place_name'] ?? 'Integrated Rurban Development and Climate Resilience Project';
@endphp

<div class="irdc-helpdesk-location-mini">
    <h4 class="irdc-helpdesk-location-mini__label">Our Location</h4>
    <p class="irdc-helpdesk-location-mini__name">{{ $placeName }}</p>

    @if ($hasLocationImage)
        <figure class="irdc-helpdesk-location-mini__photo">
            <img
                src="{{ asset(ltrim($locationImage, '/')) }}"
                alt="{{ $placeName }} — office entrance"
                width="320"
                height="160"
                loading="lazy"
                decoding="async"
            >
        </figure>
    @endif

    @if (filled($mapsDirectionsUrl))
        <a
            href="{{ $mapsDirectionsUrl }}"
            class="irdc-helpdesk-location-mini__directions"
            target="_blank"
            rel="noopener noreferrer"
        >
            Get Directions
        </a>
    @endif
</div>
