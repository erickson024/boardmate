<?php

namespace App\Notifications;

use App\Models\HostingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class HostRequestDenied extends Notification
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
            'title' => 'Host Request Denied',
            'message' => $this->request->reason ?? 'Your request was denied.',
            'request_id' => $this->request->id,
            'type' => 'danger',
        ];
    }
}