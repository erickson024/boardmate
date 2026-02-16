<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\LeaseAgreement;

class LeaseAgreementSent extends Notification
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
            'type' => 'file',
            'title' => 'Lease Agreement Received 📄',
            'message' => 'The host has sent you a lease agreement for ' . $this->lease->property->propertyName . '. Please review and sign.',
            'context' => 'Lease',
            'action_url' => route('tenant.inquiry.chat', $this->lease->inquiry_id),
            'action_label' => 'Review & Sign',
        ];
    }
}