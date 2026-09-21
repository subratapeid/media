<?php

declare(strict_types=1);

namespace Pagelyne\Media\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Pagelyne\Media\Contracts\MediaStorageInterface;
use RuntimeException;

class LocalMediaStorage implements MediaStorageInterface
{
    public function store(
        UploadedFile $file,
        ?string $directory = null
    ): array {
        $diskName = config('media.disk', 'public');

        $directory ??= config('media.path', 'media');

        $disk = Storage::disk($diskName);

        $path = $disk->putFile($directory, $file);

        if ($path === false) {
            throw new RuntimeException(
                'Unable to store the uploaded media file.'
            );
        }

        return [
            'disk' => $diskName,
            'path' => $path,
        ];
    }

    public function delete(
        string $path,
        ?string $disk = null
    ): bool {
        $disk ??= config('media.disk', 'public');

        return Storage::disk($disk)->delete($path);
    }

    public function url(
        string $path,
        ?string $disk = null
    ): string {
        $disk ??= config('media.disk', 'public');

        return Storage::disk($disk)->url($path);
    }

    public function exists(
        string $path,
        ?string $disk = null
    ): bool {
        $disk ??= config('media.disk', 'public');

        return Storage::disk($disk)->exists($path);
    }
}