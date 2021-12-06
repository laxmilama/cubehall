<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StoryReactNotification extends Notification
{
    use Queueable;
    public $reaction;
    
/**
* Create a new notification instance.
*
* @return void
*/
public function __construct($reaction)
{
    $this->reaction=$reaction;
   
}
/**
* Get the notification's delivery channels.
*
* @param mixed $notifiable
* @return array
*/
public function via($notifiable)
{
    return ['database','broadcast'];
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
        'username'=>$this->reaction->reacter->name,
        'user_thumb'=>$this->reaction->reacter->profile_image,
        //'reactioned_by'=>$this->reaction->reacter,
        'story_id'=>$this->reaction->story->id,
        'reaction'=>$this->reaction->reaction,
       
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
        'username'=>$this->reaction->reacter->name,
        'user_thumb'=>$this->reaction->reacter->profile_image,
        //'reactioned_by'=>$this->reaction->reacter,
        'story_id'=>$this->reaction->story->id,
        'reaction'=>$this->reaction->reaction,
        
    ]);
}
}