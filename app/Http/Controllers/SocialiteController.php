<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function handleProviderCallback(Request $request)
    {
        $validator = Validator::make($request->only('provider', 'access_provider_token'), [
            'provider' => ['required', 'string'],
            'access_provider_token' => ['required', 'string']
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $provider = $request->provider;
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)){
            return $validated;
        }
        $providerUser = Socialite::driver($provider)->userFromToken($request->access_provider_token);
        $user = User::updateOrCreate(
            [
                'email' => $providerUser->getEmail()
            ],
            [
                'name' => $providerUser->getName(),
                'google_token' => $providerUser->token,
                'google_refresh_token' => $providerUser->refreshToken,
            ]
        );

        $data =  [
            'token' => $user->createToken('Sanctum+Socialite')->plainTextToken,
            'user' => $user,
        ];
        return response()->json($data, 200);
    }

    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['google'])) {
            return response()->json(["message" => 'You can only login via google account'], 400);
        }
    }
}
