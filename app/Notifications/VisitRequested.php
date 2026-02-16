<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\PropertyVisit;

class VisitRequested extends Notification
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
            'type' => 'mention',
            'title' => 'Property Visit Requested 📅',
            'message' => $this->visit->tenant->firstName . ' wants to visit ' . $this->visit->property->propertyName . ' on ' . $this->visit->proposed_date->format('M j, Y \a\t g:i A'),
            'context' => 'Visit',
            'action_url' => route('host.inquiry.chat', $this->visit->inquiry_id),
            'action_label' => 'Confirm Visit',
        ];
    }
}