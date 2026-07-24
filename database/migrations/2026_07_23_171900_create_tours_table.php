<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();

            $table->string('cover_image');

            // Estes permanecem na Tour
            $table->unsignedTinyInteger('max_capacity');

            $table->boolean('featured_home')->default(false);
            $table->boolean('available')->default(true);
            $table->unsignedInteger('display_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};