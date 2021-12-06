<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class ParlorReminderNotification extends Notification
{
    use Queueable;
    public $ticket;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticket, $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    
    public function toWebPush($notifiable, $notification)
    {

        return (new WebPushMessage)
            ->title($this->ticket->parlor->title . ' Starting soon!')
            ->icon('/assets/00ch26edc-bd49-64cdf-ico-128.png')
            ->body('Starting in 30 minutes.')
            ->action('Show Ticket', 'notification_action');
    }
}
