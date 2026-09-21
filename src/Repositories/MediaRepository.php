<?php

declare(strict_types=1);

namespace Pagelyne\Media\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Pagelyne\Media\Contracts\MediaRepositoryInterface;
use Pagelyne\Media\Models\Media;

class MediaRepository implements MediaRepositoryInterface
{
    public function find(int|string $id): ?Media
    {
        return Media::query()->find($id);
    }

    public function create(array $data): Media
    {
        return Media::query()->create($data);
    }

    public function update(Media $media, array $data): Media
    {
        $media->update($data);

        return $media->refresh();
    }

    public function delete(Media $media): bool
    {
        return (bool) $media->delete();
    }

    public function all(): Collection
    {
        return Media::query()
            ->latest()
            ->get();
    }
}