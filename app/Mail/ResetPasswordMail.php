<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $resetUrl;

    public $user;

    public $tries = 3;

    public $timeout = 30;

    /**
     * Create a new message instance.
     */
    public function __construct($resetUrl, $user = null)
    {
        if (empty($resetUrl)) {
            throw new \InvalidArgumentException('Reset URL cannot be empty');
        }

        $this->resetUrl = $resetUrl;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        try {
            return new Envelope(
                subject: 'Reset Your Password - '.config('app.name'),
                from: config('mail.from.address', 'noreply@dost.gov.ph'),
                replyTo: config('mail.from.address', 'noreply@dost.gov.ph'),
            );
        } catch (\Exception $e) {
            Log::error('Failed to create mail envelope: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        try {
            return new Content(
                markdown: 'emails.reset-password',
                with: [
                    'resetUrl' => $this->resetUrl,
                    'user' => $this->user,
                ],
            );
        } catch (\Exception $e) {
            Log::error('Failed to create mail content: '.$e->getMessage());
            throw $e;
        }
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

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Password reset mail failed after retries', [
            'exception' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
            'user' => $this->user ? $this->user->id : null,
            'resetUrl' => $this->resetUrl,
        ]);
    }
}
