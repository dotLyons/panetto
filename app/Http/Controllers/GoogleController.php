<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            session()->put('survey_google_user', [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(), // Aprovechamos de traer su foto
            ]);

            return redirect()->route('survey.form');

        } catch (\Exception $e) {
            return redirect()->route('survey.form');
        }
    }
}
