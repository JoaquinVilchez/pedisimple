<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdatePricesReminder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(env('APP_NAME').' - Por favor, actualiza tus precios.')
            ->line('Es importante mantener tus precios actualizados en la plataforma para que los clientes tengan una mejor experiencia a la hora de pedir tus productos. Por eso te ofrecemos actualizar tus precios de una forma muy sencilla y rápida, sólo te tomará unos minutos.')
            ->action('Actualizar precios', (env('APP_URL').'/productos/menu'))
            ->line('Si tus precios estan actualizados, solo omite este correo.')
            ->line('¡Gracias por mantener actualizada tu información!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
