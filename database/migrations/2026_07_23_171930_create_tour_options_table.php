<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tour_options', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_id')
                ->constrained()
                ->cascadeOnDelete();

            // Duração em minutos
            $table->unsignedSmallInteger('duration_minutes');

            // Preço
            $table->decimal('price', 10, 2);

            // Ordem de apresentação
            $table->unsignedInteger('display_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_options');
    }
};