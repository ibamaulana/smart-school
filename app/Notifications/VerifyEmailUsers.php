<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail as Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailUsers extends Notification
{
    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function toMail($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60), ['user' => $notifiable->id]
        );

        $url = str_replace('/api', '', $url);

        $message = (new MailMessage)
            ->subject('Verify Email Address')
            ->greeting('Welcome to SmartSchool !')
            ->line('Thanks for joining us, here is your credentials to our system :')
            ->line('School Code : '.$notifiable->school->school_code)
            ->line('Name : '.$notifiable->name)
            ->line('Username : '.$notifiable->username)
            ->line('Email : '.$notifiable->email);

        if($notifiable->role_id != 1){
            $message = $message->line('Password :'.$notifiable->username.$notifiable->school->school_code);
        }

        $message = $message->line('Click the button below to verify your email address.')
        ->action('Verify Email Address', $url);

        return $message;
    }
    
}
