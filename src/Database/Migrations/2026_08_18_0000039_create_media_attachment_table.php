<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('media_attachments', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();

            // Media reference
            $table->uuid('media_uuid');

            // Entity reference
            $table->string('entity_service', 50);
            $table->string('entity_type', 100);
            $table->uuid('entity_uuid');

            // Purpose of attachment
            $table->string('collection', 100)->default('default');

            // Ordering
            $table->unsignedInteger('sort_order')->default(0);

            // Primary/default attachment
            $table->boolean('is_primary')->default(false);

            // Additional attachment-specific information
            $table->json('metadata')->nullable();

            $table->timestamps();

            /*
             * Logical references only.
             *
             * Do NOT create foreign keys to media/entity tables.
             * Media can be consumed by different modules/services.
             */

            $table->index('media_uuid');

            $table->index(
                ['entity_service', 'entity_type', 'entity_uuid'],
                'mat_entity_idx'
            );

            $table->index(
                ['entity_service', 'entity_type', 'entity_uuid', 'collection'],
                'mat_collection_idx'
            );

            $table->unique(
                [
                    'media_uuid',
                    'entity_service',
                    'entity_type',
                    'entity_uuid',
                    'collection',
                ],
                'mat_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_attachments');
    }
};