<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'tenant_id',
        'host_id',
        'subject',
        'status',
        'read_by_host',
    ];

    protected $casts = [
        'read_by_host' => 'boolean',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    // NEW: Relationship to messages
    public function messages()
    {
        return $this->hasMany(InquiryMessage::class)->orderBy('created_at', 'asc');
    }

    public function markAsRead()
    {
        $this->update(['read_by_host' => true]);
    }

    // NEW: Get unread messages count for a specific user
    public function unreadMessagesCount($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->count();
    }

    // NEW: Get the last message
    public function lastMessage()
    {
        return $this->messages()->latest()->first();
    }
}