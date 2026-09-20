<?php

declare(strict_types=1);

namespace Pagelyne\Media\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Pagelyne\Media\Models\Media;
use RuntimeException;

class MediaService
{
    /**
     * Get paginated media records.
     */
    public function paginate(
        int $page = 1,
        int $perPage = 24,
        ?string $search = null,
        ?string $type = null
    ): LengthAwarePaginator {
        $query = Media::query()
            ->latest();

        if ($search !== null && $search !== '') {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('filename', 'like', "%{$search}%")
                    ->orWhere(
                        'original_filename',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'title',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        if ($type !== null && $type !== '') {
            $query->where(
                'mime_type',
                'like',
                "{$type}/%"
            );
        }

        return $query->paginate(
            perPage: $perPage,
            page: $page
        );
    }

    /**
     * Find media by ID.
     */
    public function find(int|string $media): ?Media
    {
        return Media::query()->find($media);
    }

    /**
     * Find media by ID or UUID.
     */
    public function findOrFail(int|string $media): Media
    {
        if (is_string($media) && Str::isUuid($media)) {
            return Media::query()
                ->where('uuid', $media)
                ->firstOrFail();
        }

        return Media::query()->findOrFail($media);
    }

    /**
     * Upload multiple files.
     */
    public function upload(
        array|UploadedFile $files
    ): Collection {
        if ($files instanceof UploadedFile) {
            $files = [$files];
        }

        return collect($files)
            ->filter(
                fn($file) => $file instanceof UploadedFile
            )
            ->map(
                fn(UploadedFile $file) => $this->store($file)
            );
    }

    /**
     * Store a single media file.
     */
    public function store(UploadedFile $file): Media
    {
        $disk = $this->disk();
        $directory = $this->directory();

        $path = $file->store(
            $directory,
            $disk
        );

        if ($path === false) {
            throw new RuntimeException(
                'Unable to store the uploaded media file.'
            );
        }

        try {
            return Media::query()->create([
                'disk' => $disk,
                'path' => $path,
                'filename' => basename($path),
                'original_filename' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize() ?? 0,
                'checksum' => $this->checksum($file),
                'status' => 'active',
            ]);
        } catch (\Throwable $exception) {
            Storage::disk($disk)->delete($path);

            throw $exception;
        }
    }

    /**
     * Update media metadata.
     */
    public function update(
        int|string $media,
        array $data
    ): Media {
        $media = $this->findOrFail($media);

        $media->update([
            'title' => $data['title'] ?? $media->title,
            'alt_text' => $data['alt_text'] ?? $media->alt_text,
            'metadata' => $data['metadata'] ?? $media->metadata,
        ]);

        return $media->refresh();
    }

    /**
     * Delete media.
     */
    public function delete(int|string $media): bool
    {
        $media = $this->findOrFail($media);

        Storage::disk($media->disk)->delete($media->path);

        return (bool) $media->delete();
    }

    /**
     * Get media URL.
     */
    public function url(int|string $media): string
    {
        $media = $this->findOrFail($media);

        return Storage::disk($media->disk)
            ->url($media->path);
    }

    /**
     * Check whether media exists.
     */
    public function exists(int|string $media): bool
    {
        $media = $this->findOrFail($media);

        return Storage::disk($media->disk)
            ->exists($media->path);
    }

    /**
     * Calculate file checksum.
     */
    protected function checksum(UploadedFile $file): ?string
    {
        $path = $file->getRealPath();

        if ($path === false) {
            return null;
        }

        return hash_file('sha256', $path) ?: null;
    }

    /**
     * Get configured storage disk.
     */
    protected function disk(): string
    {
        return (string) config(
            'media.storage.disk',
            'public'
        );
    }

    /**
     * Get configured media directory.
     */
    protected function directory(): string
    {
        return trim(
            (string) config(
                'media.storage.directory',
                'media'
            ),
            '/'
        );
    }
}