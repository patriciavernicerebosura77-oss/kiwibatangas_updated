<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeNewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        // Pwede kang magpasa ng variables dito kung kailangan
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Maligayang Pagdating sa Kiwi Batangas',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter-welcome',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}