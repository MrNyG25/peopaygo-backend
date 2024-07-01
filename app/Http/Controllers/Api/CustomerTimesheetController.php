<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Customer;
use App\Models\TimesheetStatus;
use App\Traits\TimesheetTotal;

class CustomerTimesheetController extends ApiController
{
    use TimesheetTotal;
    
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
                            ->where('timesheet_status_id', TimesheetStatus::TO_PAY)
                            ->values();
                            
        $res = $this->computeTimesheetTotal($timesheets);

        return response()->json([
            "data" => $res['timesheets'],
            "timesheetsTotal" =>  $res['timesheetsTotal'],
        ]);
    }
}