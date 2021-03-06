<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ParlorRequestNotification extends Notification
{
    use Queueable;
    public $parlor;
    public $admin;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($parlor,$admin)
    {
        $this->parlor=$parlor;
        $this->admin=$admin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'parlor'=>$this->parlor,
            'admin'=>$this->admin,
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
            'parlor'=>$this->parlor,
            'admin'=>$this->admin,
        ]);
    }
}
