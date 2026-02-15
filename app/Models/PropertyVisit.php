<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'inquiry_id',
        'property_id',
        'tenant_id',
        'host_id',
        'proposed_date',
        'confirmed_date',
        'status',
        'tenant_notes',
        'host_notes',
        'host_instructions',
        'completed_at',
    ];

    protected $casts = [
        'proposed_date' => 'datetime',
        'confirmed_date' => 'datetime',
        'completed_at' => 'datetime',
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
}