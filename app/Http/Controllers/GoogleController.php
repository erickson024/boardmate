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

            // Create or update the user
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'google_id' => $googleUser->getId(),
                    'firstname' => $raw['given_name'] ?? $googleUser->getName(),
                    'lastname' => $raw['family_name'] ?? '',
                    'profile_photo' => $googleUser->getAvatar(),
                    'address' => $raw['locale'] ?? 'Unknown',
                    'terms' => 'accepted',
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(16)),
                ]
            );

            // Force login
            Auth::login($user, true);

            // Redirect to profile
            return redirect()->intended('/profile');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', $e->getMessage());
        }
    }
}

