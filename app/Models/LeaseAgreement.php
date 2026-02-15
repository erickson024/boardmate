<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaseAgreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'inquiry_id',
        'property_id',
        'tenant_id',
        'host_id',
        'start_date',
        'end_date',
        'monthly_rent',
        'security_deposit',
        'terms_and_conditions',
        'special_conditions',
        'status',
        'sent_at',
        'signed_at',
        'tenant_signature',
        'signed_from_ip',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'sent_at' => 'datetime',
        'signed_at' => 'datetime',
        'monthly_rent' => 'decimal:2',
        'security_deposit' => 'decimal:2',
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }

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

    public function isSigned()
    {
        return $this->status === 'signed' || $this->status === 'active';
    }
}