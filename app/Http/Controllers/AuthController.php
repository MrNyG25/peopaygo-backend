<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
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
