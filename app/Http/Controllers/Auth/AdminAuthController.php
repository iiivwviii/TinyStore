<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AdminAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $res = AdminAuthService::login($request);
        return response()->json($res);
    }

    public function logout(Request $request): JsonResponse
    {
        $res = AdminAuthService::logout($request);
        return response()->json($res);
    }
}
