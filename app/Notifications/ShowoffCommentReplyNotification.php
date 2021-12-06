<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShowoffCommentReplyNotification extends Notification
{
    use Queueable;
  
    public $comment;
    public $owners;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment,$owners)
    {
        
        $this->comment=$comment;
        $this->owners=$owners;
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
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_name'=>$this->comment->owner->name,
            'user_profile'=>$this->comment->owner->profile_image,
            'comment'=>$this->comment->comment,
            'showoff_slug'=>$this->comment->showoff->slug,
            'showoff_thumb' =>$this->comment->showoff->media
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
            'username'=>$this->comment->owner->name,
            'userthumb'=>$this->comment->owner->profile_image,
            'comment'=>$this->comment->comment,
            'showoff_id'=>$this->comment->item_id,           
        ]);
    }
}
