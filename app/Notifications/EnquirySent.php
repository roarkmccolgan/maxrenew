<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EnquirySent extends Notification
{
    use Queueable;
    public $message;
    public $subject;
    public $fullname;
    public $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($fullname, $email, $subject, $message)
    {
        $this->message = $message;
        $this->subject = $subject;
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
                    ->greeting('MaxRenew Message')
                    ->line('An enquiry was sent from '.$this->fullname)
                    ->line('Subject: '.$this->subject)
                    ->line($this->message)
                    ->action('Reply', 'mailto:'.$this->email)
                    ->line('Please respond ASAP!');
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
