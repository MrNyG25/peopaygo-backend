<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Customer;
use App\Models\PaymentType;

class CustomerTimesheetController extends ApiController
{
    /**
    * @OA\Get(
    *     path="/api/customers/{customer}/timesheets",
    *     summary="customer's timesheets",
    *     @OA\Response(
    *         response=200,
    *         description="return timesheets"
    *     ),
    *    @OA\Response(
    *         response="404",
    *         description="customer not found"
    *     )
    * )
    */
    public function index(Customer $customer)
    {
        $timesheets = $customer->employees()
                            ->with('timesheets')
                            ->get()
                            ->pluck('timesheets')
                            ->collapse()
                            ->unique('id')
                            ->values();

        $timesheets = $timesheets->map(function($timesheet){
            $timesheet->load('employee');

            if($timesheet->employee->payment_type_id == PaymentType::HOURS){
                $timesheet['total'] = $timesheet->employee->pay_rate * $timesheet->amount;
            }else{
                //because is PaymentType::SALARY
                $timesheet['total'] = $timesheet->employee->pay_rate;
            }
            return $timesheet;
        });


        return $this->showAll($timesheets);
    }
}