<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangeCodeNotification extends Notification
{
    public function __construct(
        public string $code
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Código para cambiar contraseña - Funeraria San José')
            ->view('emails.password-change-code', [
                'user' => $notifiable,
                'code' => $this->code,
            ]);
    }
}
