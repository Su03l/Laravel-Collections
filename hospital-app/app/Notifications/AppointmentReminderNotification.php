<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    // constructor
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Appointment Reminder')
                    ->line('This is a reminder for your appointment tomorrow.')
                    ->line('Doctor: ' . $this->appointment->doctor->name)
                    ->line('Date: ' . $this->appointment->appointment_date)
                    ->line('Time: ' . $this->appointment->start_time)
                    ->action('View Appointment', url('/appointments/' . $this->appointment->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'message' => 'Reminder: Appointment with Dr. ' . $this->appointment->doctor->name . ' tomorrow.',
            'date' => $this->appointment->appointment_date,
        ];
    }
}
