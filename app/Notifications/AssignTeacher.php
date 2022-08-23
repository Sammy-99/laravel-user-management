<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignTeacher extends Notification
{
    use Queueable;

    protected $student;
    protected $teacherId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($studentData, $teacherId)
    {
        $this->student = $studentData;
        $this->teacherId = $teacherId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
                    ->line('Hope you are doing well Sir. A new student assign to you by the Admin. Please find the Student\'s details below - ')
                    ->line('Name : ' . $this->student['name'])
                    ->line('Email : ' . $this->student['email'])
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
            "user_id" => $this->teacherId
        ];
    }
}
