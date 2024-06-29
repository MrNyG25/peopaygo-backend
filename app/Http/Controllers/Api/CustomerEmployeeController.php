<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Customer;

class CustomerEmployeeController extends ApiController
{
    /**
    * @OA\Get(
    *     path="/api/customers/{customer}/employees",
    *     summary="customer's employees",
    *     @OA\Response(
    *         response=200,
    *         description="return employess"
    *     ),
    *    @OA\Response(
    *         response="404",
    *         description="customer not found"
    *     )
    * )
    */
    public function index(Customer $customer)
    {
        $employees = $customer->employees()
                            ->with('paymentType')
                            ->get()
                            ->values();

        return $this->showAll($employees);
    }
}