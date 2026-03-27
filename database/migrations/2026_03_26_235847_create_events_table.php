<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_request_id')
                ->nullable()
                ->constrained('event_requests')
                ->nullOnDelete();

            $table->string('title');

            $table->foreignId('instance_id')->constrained('instances')->restrictOnDelete();
            $table->foreignId('event_type_id')->constrained('event_types')->restrictOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('venue_id')->nullable()->constrained('venues')->nullOnDelete();

            $table->string('event_mode')->default('internal');

            $table->timestamp('start_at');
            $table->timestamp('end_at');

            $table->unsignedInteger('expected_attendees')->nullable();

            $table->longText('description')->nullable();

            $table->string('status')->default('draft');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->string('cover_image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
