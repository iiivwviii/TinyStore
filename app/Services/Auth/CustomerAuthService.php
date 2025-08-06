<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerAuthService
{
    public function register(RegisterRequest $request): array
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        return [
            'token' => $user->createToken('customer_token')->plainTextToken,
        ];
    }

    public static function login(LoginRequest $request): array
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('customer_token')->plainTextToken;

        return [
            'message' => 'Logged in successfully',
            'token' => $token,
            'user' => $user
        ];
    }

    public static function logout(Request $request): array
    {
        $request->user()->currentAccessToken()->delete();
        return ['message' => 'Logged out'];
    }
}
