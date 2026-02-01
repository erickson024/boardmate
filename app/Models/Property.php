<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    // Table name (optional, only if different from plural form of model name)
    protected $table = 'properties';

    // Fillable fields (mass assignable)
    protected $fillable = [
        'user_id',
        'propertyName',
        'propertyCost',
        'propertyType',
        'propertyDescription',
        'address',
        'latitude',
        'longitude',
        'propertyFeatures',
        'propertyRestrictions',
        'tenantGender',
        'tenantType',
        'images',
        'terms',
    ];

    protected $casts = [
        'images' => 'array',    // auto converts JSON ↔ PHP array
        'propertyFeatures' => 'array',    // add this
        'propertyRestrictions' => 'array', // add this
        'propertyCost' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Alternative naming (if you prefer)
    public function host()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
