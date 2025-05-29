<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // opcional
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificacionPersonalizada extends Notification
{
    use Queueable;

    protected $titulo;
    protected $mensaje;
    protected $tipo;
    protected $canales;
    protected $remitente;  // nuevo

    public function __construct($titulo, $mensaje, $tipo = 'notificacion', $canales = ['database'], $remitente = null)
    {
        $this->titulo = $titulo;
        $this->mensaje = $mensaje;
        $this->tipo = $tipo;
        $this->canales = $canales;
        $this->remitente = $remitente;
    }

    public function via($notifiable)
    {
        return $this->canales;
    }

    public function toDatabase($notifiable)
    {
        return [
            'titulo' => $this->titulo,
            'mensaje' => $this->mensaje,
            'tipo' => $this->tipo,
            'remitente_id' => $this->remitente?->id,
            'remitente_name' => $this->remitente?->name,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->titulo)
            ->line($this->mensaje)
            ->action('Ver detalles', url('/'))
            ->line('Gracias por usar nuestra aplicación!');
    }
}
