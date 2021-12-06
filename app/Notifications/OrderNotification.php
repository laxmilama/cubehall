<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification
{
    use Queueable;
    public $order, $customer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $customer)
    {
        $this->order = $order;
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
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
            ->greeting('Greetings')
            ->subject('You have received new order')
            ->line('Someone just ordered. Product Name: ' . $this->order->product_name)
            ->line('Order Id: ' . $this->order->delivered->identifier)
            ->action('View Order', url('/studio/orders'))
            ->line('Please fullfill your order as soon as possible!');
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
            'user_name' => $this->firstName($this->customer->name),
            'user_profile' => $this->customer->profile_image,
            'order_id' => $this->order->id,
            'product_name' => $this->order->product_name,
            'product_thumb' => $this->order->thumbnail,
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
            'user_name' => $this->firstName($this->customer->name),
            'user_profile' => $this->customer->profile_image,
            'order_id' => $this->order->id,
            'product_name' => $this->order->product_name,
            'product_thumb' => $this->order->thumbnail,


        ]);
    }

    function firstName($name)
    {
        $nameArray = explode(" ", $name);
        return $nameArray[0];
    }
}
