<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
{
    public $orderstatus;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($orderstatus)
    {
        $this->orderstatus=$orderstatus;
     
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database','broadcast'];
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
      
        ->subject('Order Status')
    
        ->greeting('Greetings ' . $this->orderstatus->customers->name)
        ->line($this->orderstatus->product_name . ',' . ' has been ' . $this->orderstatus->status )
        ->action('View Status', url('/orders'))
        ->line('Thank you for connecting with ClubHAll');
           
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
            'product_name'=>$this->orderstatus->product_name,
            'product_thumb'=>$this->orderstatus->thumbnail,
            'status'=>$this->orderstatus->status,
   
        ];
    }
     /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toBroadcaste($notifiable)
    {
        return new BroadcasteMessage([

            'product_name'=>$this->orderstatus->product_name,
            'product_thumb'=>$this->orderstatus->thumbnail,
            'status'=>$this->orderstatus->status,
           

        ]);
    }
}
