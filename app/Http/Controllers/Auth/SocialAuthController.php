<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::updateOrCreate([
                'google_id' => $googleUser->id,
            ], [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => null, // Managed by Google
                'role' => 'user', // Default role
                'email_verified_at' => now(), // Trusted provider
                // 'avatar' => $googleUser->avatar // Could map avatar if we want
            ]);
    
            Auth::login($user);
    
            return redirect()->route('home')->with('success', 'Google ile başarıyla giriş yapıldı.');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google girişi sırasında bir hata oluştu.');
        }
    }
}
