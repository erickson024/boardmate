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
        'name',
        'cost',
        'type',
        'description',
        'address',
        'latitude',
        'longitude',
        'feature',
        'images',
        'tenantType',
        'tenantGender',
        'tenantRestriction',
        'terms',
        'payment',
        'agree'
    ];

    protected $casts = [
        'amenities' => 'array', // auto converts JSON ↔ PHP array
        'images' => 'array',    // auto converts JSON ↔ PHP array
        'captions' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
