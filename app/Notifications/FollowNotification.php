<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FollowNotification extends Notification
{
    use Queueable;
        public $followby;
        public $followto;
    /**
    * Create a new notification instance.
    *
    * @return void
    */
    public function __construct($followby,$followto)
    {
        $this->followby=$followby;
        $this->followto=$followto;
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
            'user_slug'=>$this->followby[0]->slug,
            'user_name'=>$this->followby[0]->name,
            'user_profile'=>$this->followby[0]->profile_image,
            'studio_slug'=>$this->followto->pagess[0]->slug,
            'studio_profile'=>$this->followto->pagess[0]->profile_image,
            'studio_name'=>$this->followto->pagess[0]->name,
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
            'user_slug'=>$this->followby[0]->slug,
            'user_name'=>$this->followby[0]->name,
            'user_profile'=>$this->followby[0]->profile_image,
            'studio_slug'=>$this->followto->pagess[0]->slug,
            'studio_profile'=>$this->followto->pagess[0]->profile_image,
            'studio_name'=>$this->followto->pagess[0]->name,
        ]);
    }
    }