<?php

declare(strict_types=1);

namespace Pagelyne\Media\Database\Seeders;

use Illuminate\Database\Seeder;

class MediaAttachmentSeeder extends Seeder
{
    public function run(): void
    {
        /*
         * Media attachments depend on entities owned by other
         * modules or services.
         *
         * Example:
         *
         * entity_service = catalogue
         * entity_type    = product
         * entity_uuid    = <product uuid>
         * collection     = gallery
         *
         * Entity-specific attachment seeders should be handled
         * by the owning module.
         */
    }
}