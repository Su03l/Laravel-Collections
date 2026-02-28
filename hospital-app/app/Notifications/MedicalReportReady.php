<?php

namespace App\Notifications;

use App\Models\MedicalRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MedicalReportReady extends Notification implements ShouldQueue
{
    use Queueable;

    protected $record;

    // constructor
    public function __construct(MedicalRecord $record)
    {
        $this->record = $record;
    }

    // via method for notification
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    // to mail to send to mail
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Medical Report Ready')
                    ->line('Your medical report is now available.')
                    ->line('Doctor: ' . $this->record->doctor->name)
                    ->line('Date: ' . $this->record->created_at->format('Y-m-d'))
                    ->action('View Report', url('/medical-records/' . $this->record->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'record_id' => $this->record->id,
            'message' => 'Your medical report from Dr. ' . $this->record->doctor->name . ' is ready.',
        ];
    }
}
