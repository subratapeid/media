<?php

declare(strict_types=1);

namespace Pagelyne\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class MediaAttachment extends Model
{
    protected $table = 'media_attachments';

    protected $fillable = [
        'uuid',
        'media_uuid',
        'entity_service',
        'entity_type',
        'entity_uuid',
        'collection',
        'sort_order',
        'is_primary',
        'metadata',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_primary' => 'boolean',
        'metadata' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (MediaAttachment $attachment): void {
            if (empty($attachment->uuid)) {
                $attachment->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the attached media.
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(
            Media::class,
            'media_uuid',
            'uuid'
        );
    }
}