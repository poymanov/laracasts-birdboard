<?php

namespace App\Services\ProjectInvite\Notifications;

use App\Services\Project\Dtos\ProjectDto;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewInvite extends Notification
{
    use Queueable;

    private ProjectDto $project;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProjectDto $project)
    {
        $this->project = $project;
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
            ->line('You invited to project: ' . $this->project->title)
            ->action('See your invites', route('profile.invitations.index'));
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
