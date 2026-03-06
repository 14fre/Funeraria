<?php

namespace App\Notifications;

use App\Models\SolicitudAfiliacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AfiliacionAprobadaNotification extends Notification
{
    use Queueable;

    public function __construct(
        public SolicitudAfiliacion $solicitud
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $plan = $this->solicitud->planExequial;
        $planNombre = $plan ? $plan->nombre : 'tu plan';

        return (new MailMessage)
            ->subject('Tu solicitud de afiliación fue aprobada - Funeraria San José')
            ->view('emails.afiliacion-aprobada', [
                'user' => $notifiable,
                'planNombre' => $planNombre,
            ]);
    }
}
