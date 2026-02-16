<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Inquiry;

class InquiryReceived extends Notification
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
            'title' => 'New Inquiry Received',
            'message' => $this->inquiry->tenant->firstName . ' ' . $this->inquiry->tenant->lastName . ' sent an inquiry for ' . $this->inquiry->property->propertyName,
            'context' => 'Inquiry',
            'action_url' => route('host.inquiry.chat', $this->inquiry->id),
            'action_label' => 'View Inquiry',
        ];
    }
}