<?php

declare(strict_types=1);

namespace Pagelyne\Media\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Pagelyne\Media\Contracts\MediaRepositoryInterface;
use Pagelyne\Media\Contracts\MediaStorageInterface;
use Pagelyne\Media\Models\Media;

class MediaService
{
    public function __construct(
        protected MediaRepositoryInterface $repository,
        protected MediaStorageInterface $storage,
        protected MediaUploadService $uploadService
    ) {
    }

    public function upload(
        UploadedFile $file,
        ?string $directory = null,
        ?int $uploadedBy = null
    ): Media {
        return $this->uploadService->upload(
            file: $file,
            directory: $directory,
            uploadedBy: $uploadedBy
        );
    }

    public function find(int|string $id): ?Media
    {
        return $this->repository->find($id);
    }

    public function all(): Collection
    {
        return $this->repository->all();
    }

    public function delete(Media $media): bool
    {
        $deleted = $this->repository->delete($media);

        if ($deleted) {
            $this->storage->delete(
                $media->path,
                $media->disk
            );
        }

        return $deleted;
    }

    public function url(Media $media): string
    {
        return $this->storage->url(
            $media->path,
            $media->disk
        );
    }
}