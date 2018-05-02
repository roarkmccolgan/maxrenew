<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class QuestionAsked extends Notification
{
    use Queueable;

    public $product;
    public $question;
    public $fullname;
    public $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($product,$question,$fullname,$email)
    {
        $this->product = $product;
        $this->question = $question;
        $this->fullname = $fullname;
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->greeting('MaxRenew New Question')
                    ->line('A question about '.$this->product->name.' was asked by '.$this->fullname)
                    ->line('Question: '.$this->question->comment)
                    ->action('Reply', url($this->product->path .'/'. $this->product->alias))
                    ->line('Please answer ASAP!');
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
            //
        ];
    }
}
