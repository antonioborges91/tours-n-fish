<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationAdminCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Reservation $reservation
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nova reserva #' . $this->reservation->reservation_number . ' — Tours N Fish',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-admin-created',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}