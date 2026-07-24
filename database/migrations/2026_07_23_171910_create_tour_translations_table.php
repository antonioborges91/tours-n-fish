<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_translations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('locale', ['pt', 'en']);

            $table->string('name');
            $table->text('short_description');
            $table->longText('full_description');
            $table->text('important_information')->nullable();

            $table->timestamps();

            $table->unique(['tour_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_translations');
    }
};