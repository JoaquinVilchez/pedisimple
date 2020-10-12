<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewTemporaryProduct extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $restaurant;
    public $product;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($restaurant, $product)
    {
        $this->restaurant = $restaurant;
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address=env('MAIL_FROM_ADDRESS');
        $name=env('APP_NAME');
        $subject='Nuevo producto temporal en la plataforma.';
        return $this->markdown('emails.newTemporaryProduct')->from($address, $name)->subject($subject)->with([
            'restaurant'=>$this->restaurant,
            'product'=>$this->product
        ]);
    }
}
