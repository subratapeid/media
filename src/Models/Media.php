<?php

declare(strict_types=1);

namespace Pagelyne\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'uuid',
        'disk',
        'path',
        'filename',
        'original_filename',
        'mime_type',
        'extension',
        'size',
        'width',
        'height',
        'checksum',
        'title',
        'alt_text',
        'metadata',
        'status',
    ];

    protected $casts = [
        'size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'metadata' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Media $media): void {
            if (empty($media->uuid)) {
                $media->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get attachments for this media.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(
            MediaAttachment::class,
            'media_uuid',
            'uuid'
        );
    }

    /**
     * Get the media URL.
     */
    public function getUrlAttribute(): string
    {
        return \Storage::disk($this->disk)->url($this->path);
    }

    /**
     * Determine whether the media is an image.
     */
    public function isImage(): bool
    {
        return $this->mime_type !== null
            && str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Determine whether the media is a video.
     */
    public function isVideo(): bool
    {
        return $this->mime_type !== null
            && str_starts_with($this->mime_type, 'video/');
    }

    /**
     * Determine whether the media is audio.
     */
    public function isAudio(): bool
    {
        return $this->mime_type !== null
            && str_starts_with($this->mime_type, 'audio/');
    }

    /**
     * Determine whether the media is a document.
     */
    public function isDocument(): bool
    {
        return $this->mime_type === 'application/pdf'
            || (
                $this->mime_type !== null
                && str_starts_with($this->mime_type, 'text/')
            );
    }
}