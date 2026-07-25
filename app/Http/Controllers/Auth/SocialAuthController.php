<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    // Step 1: User ko Google/Facebook pe bhejna
    public function redirect($provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }

    // Step 2: Google/Facebook se wapas aane ke baad
    public function callback($provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')
                ->with('message', 'Login failed. Please try again.')
                ->with('type', 'error');
        }

        $email = strtolower(trim($socialUser->getEmail() ?? ''));

        if (empty($email)) {
            return redirect('/login')
                ->with('message', 'We could not get your email from ' . ucfirst($provider) . '. Please try another method.')
                ->with('type', 'error');
        }

        // Block @hyst.uk email addresses (jaise normal register me hai)
        if (str_ends_with($email, 'hyst.uk')) {
            return redirect('/login')
                ->with('message', 'Registration with @hyst.uk email addresses is not allowed.')
                ->with('type', 'error');
        }

        $emailHash = hash('sha256', $email);

        $user = User::where('email_hash', $emailHash)->first();

        $isNewUser = false;

        if ($user) {
            // Existing user -> agar pehle social se link nahi tha to link kar do
            if (empty($user->provider)) {
                $user->provider = $provider;
                $user->provider_id = $socialUser->getId();
            }

            if (!$user->email_verified) {
                $user->email_verified = 1;
                $user->email_verified_at = now();
            }

            $user->save();
        } else {
            // Naya user -> auto register (role hamesha 'user' hi rahega)
            $isNewUser = true;

            $user = User::create([
                'name'              => $socialUser->getName() ?: $socialUser->getNickname() ?: 'User',
                'email'             => $email,
                'password'          => bcrypt(Str::random(24)),
                'role'              => 'user',
                'provider'          => $provider,
                'provider_id'       => $socialUser->getId(),
                'email_verified'    => 1,
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, true);

        // Sirf normal user flow hai -> hamesha home pe bhejna
        return redirect('/')
            ->with([
                'message' => $isNewUser
                    ? 'Account created and logged in successfully!'
                    : 'Login successful. Welcome back! Enjoy your delicious food.',
                'type' => 'success',
            ]);
    }
}