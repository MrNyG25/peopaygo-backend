<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Customer;
use App\Models\PaymentPeriod;
use App\Traits\TimesheetTotal;

class PaymentPeriodTimesheetController extends ApiController
{
    use TimesheetTotal;
    /**
    * @OA\Get(
    *     path="/api/payment_periods/{payment_period}/timesheets",
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
    public function index(PaymentPeriod $payment_period)
    {
        $timesheets = $payment_period->timesheets()
                                    ->get();

        $res = $this->computeTimesheetTotal($timesheets);

        return response()->json([
            "data" => $res['timesheets'],
            "timesheetsTotal" =>  $res['timesheetsTotal'],
        ]);
    }
}