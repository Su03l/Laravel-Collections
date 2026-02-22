<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SecurityAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $type;
    public $details;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param string $type (login, password_changed, profile_updated)
     * @param array $details (ip, device, time)
     */
    public function __construct($user, $type, $details = [])
    {
        $this->user = $user;
        $this->type = $type;
        $this->details = $details;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match ($this->type) {
            'login' => 'تنبيه أمني: تسجيل دخول جديد',
            'password_changed' => 'تنبيه أمني: تم تغيير كلمة المرور',
            'profile_updated' => 'تنبيه أمني: تم تحديث بيانات الحساب',
            default => 'تنبيه أمني من Hospital App',
        };

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.security_alert',
            with: [
                'name' => $this->user->name,
                'type' => $this->type,
                'details' => $this->details,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
