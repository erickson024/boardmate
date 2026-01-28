<?php

namespace App\Notifications;

use App\Models\HostingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class HostRequestApproved extends Notification
{
    use Queueable;

    public function __construct(public HostingRequest $request)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Host Request Approved',
            'message' => 'Congratulations! You are now a verified host.',
            'request_id' => $this->request->id,
            'type' => 'success',
            'action_url' => route('host.welcome'),
        ];
    }
}