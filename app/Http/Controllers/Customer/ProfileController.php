<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function show(): UserResource
    {
        return new UserResource(auth()->user());
    }
}
