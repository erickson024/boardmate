<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\PropertyVisit;

class VisitConfirmed extends Notification
{
    use Queueable;

    public $visit;

    public function __construct(PropertyVisit $visit)
    {
        $this->visit = $visit;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'success',
            'title' => 'Visit Confirmed! ✅',
            'message' => 'Your visit to ' . $this->visit->property->propertyName . ' has been confirmed for ' . $this->visit->confirmed_date->format('M j, Y \a\t g:i A'),
            'context' => 'Visit',
            'action_url' => route('tenant.inquiry.chat', $this->visit->inquiry_id),
            'action_label' => 'View Details',
        ];
    }
}