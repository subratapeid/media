<?php

declare(strict_types=1);

namespace Pagelyne\Media\Contracts;

use Pagelyne\Media\Models\Media;
use Illuminate\Database\Eloquent\Collection;

interface MediaRepositoryInterface
{
    public function find(int|string $id): ?Media;

    public function create(array $data): Media;

    public function update(Media $media, array $data): Media;

    public function delete(Media $media): bool;

    public function all(): Collection;
}