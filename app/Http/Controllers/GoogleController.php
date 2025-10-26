<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle callback
    public function handleGoogleCallback()
    {
        try {
            // Stateless prevents session issues
            $googleUser = Socialite::driver('google')->stateless()->user();
            $raw = $googleUser->user;

            // First try to find an existing user
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update only Google-specific fields if user exists
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            } else {
                // Create new user if none exists
                $user = User::create([
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'firstname' => $raw['given_name'] ?? $googleUser->getName(),
                    'lastname' => $raw['family_name'] ?? '',
                    'profile_photo' => $googleUser->getAvatar(),
                    'address' => $raw['locale'] ?? 'Unknown',
                    'terms' => 'accepted',
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(16)),
                    'type' => 'tenant',
                ]);
            }

            // Force login
            Auth::login($user, true);

            // Redirect to profile
            return redirect()->intended('/profile');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', $e->getMessage());
        }
    }
}

