<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/payment-types",
    *     summary="Show all payment types",
    *     @OA\Response(
    *         response=200,
    *         description="Show all payment types."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="show empty array"
    *     )
    * )
    */
    public function index()
    {
        $users = PaymentType::all();

        return $this->showAll($users);
    }

}
