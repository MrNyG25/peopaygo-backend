<?php

namespace App\Traits;

use App\Models\PaymentType;
use Illuminate\Support\Collection;

trait TimesheetTotal{

    protected function computeTimesheetTotal(Collection $timesheets, $code = 200){
        $timesheets = $timesheets->map(function($timesheet){
            $timesheet->load('employee.paymentType');
            $timesheet->load('timesheetStatus');

            if($timesheet->employee->payment_type_id == PaymentType::HOURS){
                $timesheet['total'] = $timesheet->employee->pay_rate * $timesheet->amount;
            }else{
                //because is PaymentType::SALARY
                $timesheet['total'] = $timesheet->employee->pay_rate;
            }
            
            return $timesheet;
        })->sortDesc()->values();

        $timesheetsTotal = $timesheets->sum('total');

        return [
            "timesheets" => $timesheets,
            "timesheetsTotal" => $timesheetsTotal
        ];
    }

}