<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class NotificationBell extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        $this->loadNotifications();
    }

    // This method runs automatically every 10 seconds
    public function pollNotifications()
    {
        $this->loadNotifications();
    }

    #[On('notification-sent')]
    public function loadNotifications()
    {
        $this->notifications = auth()->user()
            ->notifications()
            ->take(10)
            ->get();
            
        $this->unreadCount = auth()->user()
            ->unreadNotifications()
            ->count();
    }

    public function markAsRead($notificationId)
    {
        auth()->user()
            ->notifications()
            ->where('id', $notificationId)
            ->update(['read_at' => now()]);
            
        $this->loadNotifications();
    }

    public function markAllAsRead()
    {
        auth()->user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);
            
        $this->loadNotifications();
    }

    public function deleteNotification($notificationId)
    {
        auth()->user()
            ->notifications()
            ->where('id', $notificationId)
            ->delete();
            
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}