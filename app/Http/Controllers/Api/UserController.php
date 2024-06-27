<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


/**
* @OA\Info(title="API peopaygo", version="1.0")
*
* @OA\Server(url="http://127.0.0.1:8000")
*/
class UserController extends ApiController
{
    /**
    * @OA\Get(
    *     path="/api/users",
    *     summary="Show all users",
    *     @OA\Response(
    *         response=200,
    *         description="Show all users."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="show empty array"
    *     )
    * )
    */
    public function index()
    {
        $users = User::all();

        return $this->showAll($users);
    }
}
