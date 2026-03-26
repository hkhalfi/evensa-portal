<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_requests', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->foreignId('instance_id')->constrained('instances')->cascadeOnDelete();
            $table->foreignId('event_type_id')->constrained('event_types')->restrictOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('venue_id')->nullable()->constrained('venues')->nullOnDelete();

            $table->string('event_mode')->default('internal');
            $table->timestamp('start_at');
            $table->timestamp('end_at');

            $table->unsignedInteger('expected_attendees')->nullable();

            $table->longText('description');
            $table->string('status')->default('draft');

            $table->timestamp('submitted_at')->nullable();
            $table->longText('review_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_requests');
    }
};
