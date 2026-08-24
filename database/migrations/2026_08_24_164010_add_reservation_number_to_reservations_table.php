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
        Schema::table('reservations', function (Blueprint $table) {

            $table->string('reservation_number', 20)
                ->nullable()
                ->unique()
                ->after('id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {

            $table->dropUnique([
                'reservation_number',
            ]);

            $table->dropColumn('reservation_number');

        });
    }
};