<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/*
* @OA\Tag(
*     name="Auth",
*     description="All user auth API endpoints"
*)
*/
class AuthController extends ApiController
{

    /**
    * @OA\Post(
    *     path="/api/login",
    *     summary="users login",
    *     @OA\Response(
    *         response=200,
    *         description="return token"
    *     ),
    *     @OA\Response(
    *         response="422",
    *         description="show email or password invalid message"
    *     ),
    *    @OA\Response(
    *         response="400",
    *         description="fields required message"
    *     )
    * )
    */
    public function login(Request $request): JsonResponse
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required|email:rfc',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return $this->errorResponse("email or password invalid", 422);
        }

        return $this->successResponse([
            'token' => $user->createToken("user-token")->plainTextToken
        ], 200);
    }


    /**
    * @OA\Post(
    *     path="/api/logout",
    *     summary="users logout",
    *     @OA\Response(
    *         response=200,
    *         description="return success"
    *     ),
    *     @OA\Response(
    *         response="401",
    *         description="unauthorized message"
    *     )
    * )
    */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $this->successResponse([
            "message" => "logged out"
        ], 200);
    }

    /**
    * @OA\Post(
    *     path="/api/user",
    *     summary="user detail",
    *     @OA\Response(
    *         response=200,
    *         description="return user"
    *     ),
    *     @OA\Response(
    *         response="401",
    *         description="unauthorized message"
    *     )
    * )
    */
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        return $this->showOne($user);
    }


}
