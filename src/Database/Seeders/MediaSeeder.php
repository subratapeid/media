<?php

declare(strict_types=1);

namespace Pagelyne\Media\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Pagelyne\Media\Models\Media;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $disk = (string) config(
            'media.storage.disk',
            'public'
        );

        $mediaDirectory = trim(
            (string) config(
                'media.storage.directory',
                'media'
            ),
            '/'
        );

        $media = [
            [
                'filename' => 'pagelyne-logo.svg',
                'original_filename' => 'pagelyne-logo.svg',
                'mime_type' => 'image/svg+xml',
                'extension' => 'svg',
                'size' => 12540,
                'width' => null,
                'height' => null,
                'title' => 'Pagelyne Logo',
                'alt_text' => 'Pagelyne logo',
                'path' => "{$mediaDirectory}/system/pagelyne-logo.svg",
                'metadata' => [
                    'category' => 'system',
                    'source' => 'seed',
                ],
            ],
            [
                'filename' => 'sample-banner.jpg',
                'original_filename' => 'sample-banner.jpg',
                'mime_type' => 'image/jpeg',
                'extension' => 'jpg',
                'size' => 245760,
                'width' => 1920,
                'height' => 720,
                'title' => 'Sample Banner',
                'alt_text' => 'Sample website banner',
                'path' => "{$mediaDirectory}/samples/sample-banner.jpg",
                'metadata' => [
                    'category' => 'banner',
                    'source' => 'seed',
                ],
            ],
            [
                'filename' => 'sample-product.jpg',
                'original_filename' => 'sample-product.jpg',
                'mime_type' => 'image/jpeg',
                'extension' => 'jpg',
                'size' => 184320,
                'width' => 1200,
                'height' => 1200,
                'title' => 'Sample Product Image',
                'alt_text' => 'Sample product image',
                'path' => "{$mediaDirectory}/samples/sample-product.jpg",
                'metadata' => [
                    'category' => 'product',
                    'source' => 'seed',
                ],
            ],
            [
                'filename' => 'sample-document.pdf',
                'original_filename' => 'sample-document.pdf',
                'mime_type' => 'application/pdf',
                'extension' => 'pdf',
                'size' => 327680,
                'width' => null,
                'height' => null,
                'title' => 'Sample Document',
                'alt_text' => null,
                'path' => "{$mediaDirectory}/samples/sample-document.pdf",
                'metadata' => [
                    'category' => 'document',
                    'source' => 'seed',
                ],
            ],
        ];

        foreach ($media as $item) {
            Media::query()->updateOrCreate(
                [
                    'path' => $item['path'],
                ],
                [
                    'uuid' => (string) Str::uuid(),
                    'disk' => $disk,
                    'filename' => $item['filename'],
                    'original_filename' => $item['original_filename'],
                    'mime_type' => $item['mime_type'],
                    'extension' => $item['extension'],
                    'size' => $item['size'],
                    'width' => $item['width'] ?? null,
                    'height' => $item['height'] ?? null,
                    'checksum' => null,
                    'title' => $item['title'] ?? null,
                    'alt_text' => $item['alt_text'] ?? null,
                    'metadata' => $item['metadata'] ?? null,
                    'status' => 'active',
                ]
            );
        }
    }
}