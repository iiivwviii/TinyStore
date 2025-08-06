<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Author;
use App\Models\User;
use App\Services\CustomerAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class CustomerAuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $res = CustomerAuthService::register($request);
        return response()->json($res);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $res = CustomerAuthService::login($request);
        return response()->json($res);
    }

    public function logout(Request $request): JsonResponse
    {
        $res = CustomerAuthService::logout($request);
        return response()->json($res);
    }
}
