<?php

namespace App\Notifications;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PropertyCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Property $property)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Property Added Successfully',
            'message' => "Your property '{$this->property->propertyName}' has been successfully listed!",
            'property_id' => $this->property->id,
            'type' => 'success',
            'action_url' => route('user.dashboard', ['currentTab' => 'property-list']),
            'action_label' => 'View Property',
        ];
    }
}