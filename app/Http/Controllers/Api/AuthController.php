<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends ApiController
{
    public function login(): JsonResponse
    {


        $user = User::where('email', "test@example.com")->first();

        /* if (! $user || ! Hash::check(request()->password, $user->password)) {
            return response()->json([
                'token' => "not posible"
            ]);
        } */

        return response()->json([
            'token' => $user->createToken("ff")->plainTextToken
        ]);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
