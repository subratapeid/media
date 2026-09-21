<?php

declare(strict_types=1);

namespace Pagelyne\Media\Services;

use Illuminate\Http\UploadedFile;
use Pagelyne\Media\Contracts\MediaRepositoryInterface;
use Pagelyne\Media\Contracts\MediaStorageInterface;
use Pagelyne\Media\Models\Media;

class MediaUploadService
{
    public function __construct(
        protected MediaRepositoryInterface $repository,
        protected MediaStorageInterface $storage
    ) {
    }

    public function upload(
        UploadedFile $file,
        ?string $directory = null,
        ?int $uploadedBy = null
    ): Media {
        $stored = $this->storage->store(
            $file,
            $directory
        );

        $mimeType = $file->getMimeType();
        $extension = $file->getClientOriginalExtension();

        $data = [
            'disk' => $stored['disk'],
            'path' => $stored['path'],
            'original_filename' => $file->getClientOriginalName(),
            'filename' => basename($stored['path']),
            'extension' => $extension,
            'mime_type' => $mimeType,
            'file_size' => $file->getSize(),
            'uploaded_by' => $uploadedBy,
        ];

        return $this->repository->create($data);
    }
}