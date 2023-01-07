<?php

namespace App\Services\ProjectInvite\Notifications;

use App\Services\ProjectInvite\Dtos\ProjectInviteDto;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RejectInvite extends Notification
{
    use Queueable;

    private ProjectInviteDto $projectInvite;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProjectInviteDto $projectInvite)
    {
        $this->projectInvite = $projectInvite;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line('User ' . $this->projectInvite->user->name . ' was rejected invite to your project ' . $this->projectInvite->project->title . '.')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
