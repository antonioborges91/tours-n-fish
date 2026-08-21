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
        Schema::create('reservations', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Identificação pública
            |--------------------------------------------------------------------------
            */

            $table->string('public_token', 64)->unique();


            /*
            |--------------------------------------------------------------------------
            | Passeio
            |--------------------------------------------------------------------------
            */

            $table->foreignId('tour_id')
                ->constrained('tours')
                ->restrictOnDelete();

            $table->foreignId('tour_option_id')
                ->constrained('tour_options')
                ->restrictOnDelete();

            $table->foreignId('tour_option_schedule_id')
                ->constrained('tour_option_schedules')
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Data e horário reservado
            |--------------------------------------------------------------------------
            */

            $table->date('booking_date');

            /*
             * Guardamos o horário como snapshot.
             *
             * Mesmo que o horário configurado em
             * tour_option_schedules seja alterado no futuro,
             * a reserva mantém o horário originalmente reservado.
             */

            $table->time('start_at');
            $table->time('end_at');

            $table->unsignedInteger('participants');


            /*
            |--------------------------------------------------------------------------
            | Dados do cliente
            |--------------------------------------------------------------------------
            */

            $table->string('customer_name');

            $table->string('customer_email');

            $table->string('customer_phone');

            $table->text('customer_message')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Valores
            |--------------------------------------------------------------------------
            */

            $table->decimal('total_amount', 10, 2);

            $table->decimal('deposit_percentage', 5, 2)
                ->default(10.00);

            $table->decimal('deposit_amount', 10, 2);


            /*
            |--------------------------------------------------------------------------
            | Estado da reserva
            |--------------------------------------------------------------------------
            */

            $table->string('status', 30)
                ->default('pending_payment');


            /*
            |--------------------------------------------------------------------------
            | Pagamento
            |--------------------------------------------------------------------------
            */

            $table->string('payment_proof')->nullable();

            $table->timestamp('payment_submitted_at')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Datas de estado
            |--------------------------------------------------------------------------
            */

            $table->timestamp('confirmed_at')->nullable();

            $table->timestamp('cancelled_at')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Índices
            |--------------------------------------------------------------------------
            */

            $table->index([
                'booking_date',
                'start_at',
                'end_at',
            ]);

            $table->index('status');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};