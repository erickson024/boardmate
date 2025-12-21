<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'role',
        'terms',
        'password',
        'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ===== Online Status Methods ===== */

    public function markAsOnline()
    {
        Cache::put('user-is-online-' . $this->id, true, now()->addMinutes(2));
        Cache::forget('user-is-online-' . $this->id);
    }

    public function markAsOffline()
    {
        Cache::forget('user-is-online-' . $this->id);
    }

    public function isOnline(): bool
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function updateActivity()
    {
        $now = now();
        
        // Mark user online
        Cache::put('user-is-online-' . $this->id, true, $now->addMinutes(2));

        // Store last activity as Carbon instance
        Cache::put('user-last-activity-' . $this->id, $now, $now->addMinutes(2));
    }
}