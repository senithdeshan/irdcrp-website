<?php

namespace App\Support;

class ContactLocation
{
    /**
     * @return array<string, mixed>
     */
    public static function page(): array
    {
        return app(SiteSettings::class)->contactPageForPublic();
    }

    /**
     * @return array<string, mixed>
     */
    public static function config(): array
    {
        $location = self::page()['location'] ?? null;

        if (is_array($location) && $location !== []) {
            return $location;
        }

        return config('irdcrp.contact.location', []);
    }

    public static function address(): string
    {
        return (string) (self::page()['address'] ?? config('irdcrp.contact.address', ''));
    }

    public static function imageUrl(): ?string
    {
        $configured = self::config()['image'] ?? null;

        if (! filled($configured)) {
            return null;
        }

        if (
            str_starts_with($configured, 'contact/')
            || str_starts_with($configured, 'storage/')
            || str_starts_with($configured, 'http://')
            || str_starts_with($configured, 'https://')
        ) {
            return app(SiteSettings::class)->contactLocationImageUrl($configured);
        }

        $path = ltrim($configured, '/');

        if (is_file(public_path($path))) {
            return asset($path);
        }

        $base = preg_replace('/\.(png|jpe?g|webp)$/i', '', $path) ?: $path;

        foreach (['jpg', 'jpeg', 'png', 'webp'] as $extension) {
            $candidate = $base.'.'.$extension;

            if (is_file(public_path($candidate))) {
                return asset($candidate);
            }
        }

        return asset($path);
    }

    public static function mapEmbedUrl(): ?string
    {
        $location = self::config();

        if (filled($location['map_embed_url'] ?? null)) {
            return $location['map_embed_url'];
        }

        $lat = $location['latitude'] ?? null;
        $lng = $location['longitude'] ?? null;
        $zoom = (int) ($location['map_zoom'] ?? 19);

        if (! filled($lat) || ! filled($lng)) {
            return config('irdcrp.map_embed_url');
        }

        return sprintf(
            'https://www.google.com/maps?q=%s,%s&hl=en&z=%d&t=h&output=embed',
            $lat,
            $lng,
            $zoom,
        );
    }

    public static function directionsUrl(): ?string
    {
        $location = self::config();

        if (filled($location['maps_url'] ?? null)) {
            return $location['maps_url'];
        }

        $lat = $location['latitude'] ?? null;
        $lng = $location['longitude'] ?? null;

        if (! filled($lat) || ! filled($lng)) {
            return null;
        }

        return sprintf('https://www.google.com/maps/dir/?api=1&destination=%s,%s', $lat, $lng);
    }

    public static function phoneTel(): string
    {
        return preg_replace('/\D+/', '', (string) (self::page()['phone'] ?? '')) ?: '';
    }
}
