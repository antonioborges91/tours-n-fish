<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Illuminate\Console\Command;

class ExpireReservations extends Command
{
    /**
     * Nome e assinatura do comando.
     */
    protected $signature = 'reservations:expire';

    /**
     * Descrição do comando.
     */
    protected $description = 'Marca como expiradas as reservas cujo prazo de pagamento terminou';

    /**
     * Executa o comando.
     */
    public function handle(): int
    {
        $expiredCount = Reservation::query()
            ->where('status', 'pending_payment')
            ->whereNotNull('payment_deadline_at')
            ->where('payment_deadline_at', '<=', now())
            ->update([
                'status' => 'expired',
            ]);

        $this->info(
            "Reservas expiradas: {$expiredCount}"
        );

        return self::SUCCESS;
    }
}