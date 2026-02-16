<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Inquiry;

class InquiryAccepted extends Notification
{
    use Queueable;

    public $inquiry;

    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'success',
            'title' => 'Inquiry Accepted! 🎉',
            'message' => $this->inquiry->host->firstName . ' has accepted your inquiry for ' . $this->inquiry->property->propertyName . '. You can now schedule a property visit.',
            'context' => 'Inquiry',
            'action_url' => route('tenant.inquiry.chat', $this->inquiry->id),
            'action_label' => 'Schedule Visit',
        ];
    }
}