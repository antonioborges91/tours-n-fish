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
        Schema::create('tour_option_translations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_option_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 2);

            $table->string('name');

            $table->timestamps();

            $table->unique([
                'tour_option_id',
                'locale',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_option_translations');
    }
};