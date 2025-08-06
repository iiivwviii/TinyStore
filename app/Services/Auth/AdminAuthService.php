<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthService
{
    public static function login(LoginRequest $request): array
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('admin_token')->plainTextToken;

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
