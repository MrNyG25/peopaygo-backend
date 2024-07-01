<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Customer;

class CustomerPaymentPeriodController extends ApiController
{
    /**
    * @OA\Get(
    *     path="/api/customers/{customer}/payment_periods",
    *     summary="customer's payment periods",
    *     @OA\Response(
    *         response=200,
    *         description="return payment periods"
    *     ),
    *    @OA\Response(
    *         response="404",
    *         description="customer not found"
    *     )
    * )
    */
    public function index(Customer $customer)
    {
        $paymentPeriods = $customer->employees()
                            ->with('timesheets.paymentPeriods')
                            ->get()
                            ->pluck('timesheets')
                            ->collapse()
                            ->pluck('paymentPeriods')
                            ->collapse()
                            ->sortByDesc('id')
                            ->unique('id')
                            ->values();

        return $this->showAll($paymentPeriods);
    }
}