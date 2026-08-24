<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
     * Caminho do ficheiro de diagnóstico.
     */
    private function logFile(): string
    {
        return base_path('../public_html/cron-expire.log');
    }

    /**
     * Escreve uma linha no log.
     */
    private function writeLog(string $message): void
    {
        $line = '[' . now()->format('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;

        file_put_contents(
            $this->logFile(),
            $line,
            FILE_APPEND | LOCK_EX
        );
    }

    /**
     * Executa o comando.
     */
    public function handle(): int
    {
        $this->writeLog('========================================');
        $this->writeLog('INICIO reservations:expire');

        try {
            // Informação do ambiente
            $this->writeLog('PHP: ' . PHP_VERSION);
            $this->writeLog('Laravel: ' . app()->version());
            $this->writeLog('Base path: ' . base_path());
            $this->writeLog('Base de dados: ' . DB::connection()->getDatabaseName());
            $this->writeLog('Agora: ' . now()->format('Y-m-d H:i:s'));
            $this->writeLog('Timezone Laravel: ' . config('app.timezone'));

            // Procurar todas as reservas que estão pending_payment
            $pendingReservations = Reservation::query()
                ->where('status', 'pending_payment')
                ->get([
                    'id',
                    'status',
                    'payment_deadline_at',
                ]);

            $this->writeLog(
                'Reservas pending_payment encontradas: ' .
                $pendingReservations->count()
            );

            // Mostrar cada reserva pending_payment
            foreach ($pendingReservations as $reservation) {
                $this->writeLog(
                    'ID=' . $reservation->id .
                    ' | status=' . $reservation->status .
                    ' | deadline=' .
                    ($reservation->payment_deadline_at
                        ? $reservation->payment_deadline_at->format('Y-m-d H:i:s')
                        : 'NULL')
                );
            }

            // Procurar especificamente as que já ultrapassaram o prazo
            $expiredReservations = Reservation::query()
                ->where('status', 'pending_payment')
                ->whereNotNull('payment_deadline_at')
                ->where('payment_deadline_at', '<=', now())
                ->get([
                    'id',
                    'status',
                    'payment_deadline_at',
                ]);

            $this->writeLog(
                'Reservas com deadline vencido: ' .
                $expiredReservations->count()
            );

            foreach ($expiredReservations as $reservation) {
                $this->writeLog(
                    'VAI EXPIRAR -> ID=' . $reservation->id .
                    ' | deadline=' .
                    $reservation->payment_deadline_at->format('Y-m-d H:i:s')
                );
            }

            // Atualizar
            $expiredCount = Reservation::query()
                ->where('status', 'pending_payment')
                ->whereNotNull('payment_deadline_at')
                ->where('payment_deadline_at', '<=', now())
                ->update([
                    'status' => 'expired',
                ]);

            $this->writeLog(
                'Reservas atualizadas para expired: ' .
                $expiredCount
            );

            $this->info(
                "Reservas expiradas: {$expiredCount}"
            );

            $this->writeLog('FIM reservations:expire');
            $this->writeLog('========================================');

            return self::SUCCESS;

        } catch (\Throwable $e) {

            $this->writeLog('ERRO: ' . $e->getMessage());
            $this->writeLog('Ficheiro: ' . $e->getFile());
            $this->writeLog('Linha: ' . $e->getLine());

            $this->error(
                'Erro: ' . $e->getMessage()
            );

            return self::FAILURE;
        }
    }
}