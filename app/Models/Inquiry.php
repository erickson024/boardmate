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

    public function messages()
    {
        return $this->hasMany(InquiryMessage::class)->orderBy('created_at', 'asc');
    }

    // ⭐⭐⭐ ADD THIS METHOD ⭐⭐⭐
    public function visit()
    {
        return $this->hasOne(PropertyVisit::class);
    }

    public function markAsRead()
    {
        $this->update(['read_by_host' => true]);
    }

    public function unreadMessagesCount($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->count();
    }

    public function leaseAgreement()
    {
        return $this->hasOne(LeaseAgreement::class);
    }

    public function lastMessage()
    {
        return $this->messages()->latest()->first();
    }
}
