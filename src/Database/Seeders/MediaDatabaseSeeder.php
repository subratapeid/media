<?php

declare(strict_types=1);

namespace Pagelyne\Media\Database\Seeders;

use Illuminate\Database\Seeder;

class MediaDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MediaSeeder::class,
            MediaAttachmentSeeder::class,
        ]);
    }
}