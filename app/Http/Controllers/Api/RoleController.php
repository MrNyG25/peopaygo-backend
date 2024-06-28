<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends ApiController
{
    /**
    * @OA\Get(
    *     path="/api/roles",
    *     summary="Show all roles",
    *     @OA\Response(
    *         response=200,
    *         description="Show all roles."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="show empty array"
    *     )
    * )
    */
    public function index()
    {
        $users = Role::all();

        return $this->showAll($users);
    }
}
