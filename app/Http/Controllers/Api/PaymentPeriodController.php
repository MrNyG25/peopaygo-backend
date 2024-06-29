<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\PaymentPeriod;
use App\Models\Timesheet;
use App\Models\TimesheetStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentPeriodController extends ApiController
{
        /**
    * @OA\Get(
    *     path="/api/payment_periods",
    *     summary="Show all payment periods",
    *     @OA\Response(
    *         response=200,
    *         description="Show all payment periods."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Show empty array"
    *     )
    * )
    */
    public function index()
    {
        $paymentPeriods = PaymentPeriod::with('timesheets')->get();

        return $this->showAll($paymentPeriods);
    }

    /**
    * @OA\Post(
    *     path="/api/payment_periods",
    *     summary="Payment period created successfully",
    *     @OA\Response(
    *         response=201,
    *         description="Payment period created successfully."
    *     ),
    *     @OA\Response(
    *         response="400",
    *         description="Validation rules"
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Error Something went wrong"
    *     )
    * )
    */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'note' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
            'check_date' => 'required|date',
            'timesheet_ids' => 'required|array',
            'timesheet_ids.*' => 'integer|exists:timesheets,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        Timesheet::whereIn('id', $data['timesheet_ids'])->update([
            "timesheet_status_id" => TimesheetStatus::PAYED
        ]);

        $paymentPeriod = PaymentPeriod::create([
            'note' => $data['note'],
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
            'check_date' => $data['check_date'],
        ]);

        $paymentPeriod->timesheets()->attach($data['timesheet_ids']);

        return $this->successResponse([
            "message" => "Payment period created successfully"
        ], 201);
    }

     /**
    * @OA\Get(
    *     path="/api/payment_periods/{paymentPeriod}",
    *     summary="Show a specific payment period",
    *     @OA\Response(
    *         response="404",
    *         description="Payment period not found"
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Error Something went wrong"
    *     )
    * )
    */
    public function show(PaymentPeriod $paymentPeriod)
    {
        return $this->showOne($paymentPeriod->load('timesheets'));
    }
}
