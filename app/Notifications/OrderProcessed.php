<?php

namespace App\Notifications;

use App\Channels\Messages\WhatsAppMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\WhatsAppChannel;
use App\Order;


class OrderProcessed extends Notification
{
  use Queueable;


  public $order;
  
  public function __construct(Order $order)
  {
    $this->order = $order;
  }
  
  public function via($notifiable)
  {
    return [WhatsAppChannel::class];
  }
  
  public function toWhatsApp($notifiable)
  {
    $url = url("/pedidos/nuevos");
    $name = env('APP_NAME');
    $date = $this->order->created_at->diffForHumans();

    return (new WhatsAppMessage)
        ->content("¡Te llegó un nuevo pedido desde {$name}!. Código: *{$this->order->code}*. Accede al mismo haciendo click aquí: {$url}");
  }
}