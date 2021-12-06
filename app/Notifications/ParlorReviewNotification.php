<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ParlorReviewNotification extends Notification
{
    use Queueable;
    public $review,$user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($review,$user)
    {
        $this->review=$review;
        $this->user=$user;
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
            'user_name'=>$this->user->name,
            'user_profile'=>$this->user->profile_image,
            'review'=>$this->truncateString($this->review->review, 60),
            'parlor_thumb'=>$this->review->parlor->cover,
            'parlor_slug'=>$this->review->parlor->slug,
            'parlor_title'=>$this->review->parlor->title,
         
        ];
    }
    public function toBroadcaste($notifiable)
    {
        
        return new BroadcasteMessage([
         
            'user_name'=>$this->user->name,
            'user_profile'=>$this->user->profile_image,
            'review'=>$this->truncateString($this->review->review, 60),
            'parlor_thumb'=>$this->review->parlor->cover,
            'parlor_slug'=>$this->review->parlor->slug,
            'parlor_title'=>$this->review->parlor->title,

        ]);
    }

    function truncateString($string, $limit) {
        if (strlen($string) > $limit) {
            return substr($string, 0, $limit).'...';
        } else {
            return $string;
        }
    }
}
