<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends ApiController
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
        $paymentTypes = PaymentType::all();

        return $this->showAll($paymentTypes);
    }

}
