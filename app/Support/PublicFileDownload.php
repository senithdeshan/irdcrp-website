<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicFileDownload
{
    public static function fromPublicDisk(string $path, ?string $downloadName = null): StreamedResponse
    {
        abort_unless(Storage::disk('public')->exists($path), 404);

        $name = self::sanitizeFilename($downloadName ?: basename($path));

        return Storage::disk('public')->download($path, $name, [
            'Content-Type' => 'application/octet-stream',
            'Cache-Control' => 'private, no-store, max-age=0',
        ]);
    }

    public static function downloadName(?string $originalName, ?string $title, string $path): string
    {
        if (filled($originalName)) {
            return self::sanitizeFilename($originalName);
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'pdf';
        $base = Str::slug($title ?: 'document');

        return self::sanitizeFilename($base.'.'.$extension);
    }

    public static function sanitizeFilename(string $name): string
    {
        $name = trim(str_replace(['\\', '/'], '-', $name));

        return filled($name) ? $name : 'download';
    }
}
