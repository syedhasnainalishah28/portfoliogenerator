<?php

namespace App\Mail;

use App\Models\License;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LicenseExpiringMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $license;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, License $license)
    {
        $this->user = $user;
        $this->license = $license;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Action Required: Your HA Tech License is Expiring Soon',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.license-expiring',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
