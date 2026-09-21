<?php

declare(strict_types=1);

namespace Pagelyne\Media\Contracts;

use Illuminate\Http\UploadedFile;

interface MediaStorageInterface
{
    public function store(
        UploadedFile $file,
        ?string $directory = null
    ): array;

    public function delete(
        string $path,
        ?string $disk = null
    ): bool;

    public function url(
        string $path,
        ?string $disk = null
    ): string;

    public function exists(
        string $path,
        ?string $disk = null
    ): bool;
}