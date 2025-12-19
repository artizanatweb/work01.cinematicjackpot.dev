<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminOtpEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private readonly User $user)
    {
        $locale = get_user_locale($this->user);
        app()->setLocale($locale);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $strDate = Carbon::now()->format('d/m/Y H:i');

        return new Envelope(
            subject: __("CinematicJackpot admin authentication") . ' -- ' . $strDate,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.email.otp',
            with: [
                'user' => $this->user,
                'code' => $this->user?->profile?->otp_code,
            ]
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
