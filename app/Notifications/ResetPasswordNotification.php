<?php

namespace App\Notifications;

use App\Mail\ResetPasswordMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;

    public $tries = 3; // Number of retry attempts

    public $timeout = 30; // Timeout in seconds

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): ResetPasswordMail
    {
        try {
            $resetUrl = URL::temporarySignedRoute(
                'password.reset',
                now()->addMinutes(config('auth.passwords.users.expire', 60)),
                [
                    'token' => $this->token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ]
            );

            return new ResetPasswordMail($resetUrl, $notifiable);
        } catch (\Exception $e) {
            Log::error('Password reset notification failed: '.$e->getMessage(), [
                'user_id' => $notifiable->id,
                'email' => $notifiable->getEmailForPasswordReset(),
                'exception' => $e,
            ]);
            throw $e;
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ];
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Password reset notification failed after retries', [
            'exception' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
