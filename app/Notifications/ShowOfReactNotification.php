<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShowOfReactNotification extends Notification
{
    use Queueable;
    public $reaction;
    public $showowner;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reaction)
    {
        $this->reaction = $reaction;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    // return (new MailMessage)
    // ->line('The introduction to the notification.')
    // ->action('Notification Action', url('/'))
    // ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_name' => $this->reaction->reactby->name,
            'user_profile' => $this->reaction->reactby->profile_image,
            'showoff_title' => $this->reaction->showoff->title,
            'showoff_slug' => $this->reaction->showoff->slug,
            'showoff_thumb' => $this->reaction->showoff->media,
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
            'user_name' => $this->reaction->reactby->name,
            'user_profile' => $this->reaction->reactby->profile_image,
            'showoff_title' => $this->reaction->showoff->title,
            'showoff_slug' => $this->reaction->showoff->slug,
            'showoff_thumb' => $this->reaction->showoff->media,

        ]);
    }
}
