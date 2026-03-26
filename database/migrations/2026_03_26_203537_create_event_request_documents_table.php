<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_request_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_request_id')
                ->constrained('event_requests')
                ->cascadeOnDelete();

            $table->string('document_type');
            $table->string('title');
            $table->string('file_path');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_request_documents');
    }
};
