@php
    use App\Support\ContactLocation;

    $location = ContactLocation::config();
    $locationImageUrl = ContactLocation::imageUrl();
    $mapsDirectionsUrl = ContactLocation::directionsUrl();
    $placeName = $location['place_name'] ?? 'Integrated Rurban Development and Climate Resilience Project';
@endphp

<div class="irdc-helpdesk-location-mini">
    <h4 class="irdc-helpdesk-location-mini__label">Our Location</h4>
    <p class="irdc-helpdesk-location-mini__name">{{ $placeName }}</p>

    @if ($locationImageUrl)
        <figure class="irdc-helpdesk-location-mini__photo">
            <img
                src="{{ $locationImageUrl }}"
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
