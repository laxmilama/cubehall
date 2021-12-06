<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ProductReviewNotification extends Notification
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
            'product_thumb'=>$this->review->productlist->meta->thumbnail,
            'product_name'=>$this->review->productlist->name,
            'product_slug'=>$this->review->productlist->slug,
        ];
    }
    public function toBroadcaste($notifiable)
    {
        
        return new BroadcasteMessage([         
            'user_name'=>$this->user->name,
            'user_profile'=>$this->user->profile_image,
            'review'=>$this->truncateString($this->review->review, 60),
            'product_thumb'=>$this->review->productlist->meta->thumbnail,
            'product_name'=>$this->review->productlist->name,
            'product_slug'=>$this->review->productlist->slug,

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
