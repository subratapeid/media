<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();

            // Storage
            $table->string('disk')->default('public');
            $table->string('path');

            // File information
            $table->string('filename');
            $table->string('original_filename')->nullable();

            $table->string('mime_type')->nullable();
            $table->string('extension', 20)->nullable();
            $table->unsignedBigInteger('size')->default(0);

            // Image/document metadata
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();

            // File integrity
            $table->string('checksum', 64)->nullable()->index();

            // Optional descriptive information
            $table->string('title')->nullable();
            $table->string('alt_text')->nullable();

            // Additional information
            $table->json('metadata')->nullable();

            // Processing / lifecycle
            $table->string('status', 30)->default('active')->index();

            $table->timestamps();

            $table->index('mime_type');
            $table->index('extension');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};