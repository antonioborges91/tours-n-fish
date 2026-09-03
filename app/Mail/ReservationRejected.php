<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationRejected extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Reservation $reservation
    ) {
    }

    public function envelope(): Envelope
    {
        $locale = $this->reservation->locale ?? config('app.locale');

        $subject = $locale === 'en'
            ? 'Booking #' . $this->reservation->reservation_number . ' — Payment proof rejected — Tours N Fish'
            : 'Reserva #' . $this->reservation->reservation_number . ' — Comprovativo rejeitado — Tours N Fish';

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-rejected',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}