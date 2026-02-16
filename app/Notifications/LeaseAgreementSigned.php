<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\LeaseAgreement;

class LeaseAgreementSigned extends Notification
{
    use Queueable;

    public $lease;

    public function __construct(LeaseAgreement $lease)
    {
        $this->lease = $lease;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'success',
            'title' => 'Lease Agreement Signed! ✍️',
            'message' => $this->lease->tenant->firstName . ' has signed the lease agreement for ' . $this->lease->property->propertyName . '. Move-in date: ' . $this->lease->start_date->format('M j, Y'),
            'context' => 'Lease',
            'action_url' => route('host.inquiry.chat', $this->lease->inquiry_id),
            'action_label' => 'View Details',
        ];
    }
}