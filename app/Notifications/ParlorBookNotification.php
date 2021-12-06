<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ParlorBookNotification extends Notification
{
    use Queueable;

    public $book;
    public $parlorhost;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($book)
    {
        $this->book = $book;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
             ->subject('Parlor Booked')
            ->greeting('Greetings ' . $this->book->parlor->host->name)
            ->line($this->firstName($this->book->user->name) . ',' . ' Just Book Your Parlor ' . $this->book->parlor->title . ',' . ' Ticket number: ' . $this->book->ticket_id . ' Ticket quantity: ' . $this->book->quantity)
            ->action('View Ticket', url('/'))
            ->line('Thank you for connecting with ClubHAll');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_name' => $this->firstName($this->book->user->name),
            'user_profile' => $this->book->user->profile_image,
            'parlor_title' => $this->book->parlor->title,
            'parlor_slug' => $this->book->parlor->slug,
            'parlor_thumb' => $this->book->parlor->cover,

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
            'user_name' => $this->firstName($this->book->user->name),
            'user_profile' => $this->book->user->profile_image,
            'parlor_title' => $this->book->parlor->title,
            'parlor_slug' => $this->book->parlor->slug,
            'parlor_thumb' => $this->book->parlor->cover,

        ]);
    }
    function firstName($name)
    {
        $nameArray = explode(" ", $name);
        return $nameArray[0];
    }
}

