<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends ApiController
{
    /**
    * @OA\Get(
    *     path="/api/timesheets",
    *     summary="Show all timesheets",
    *     @OA\Response(
    *         response=200,
    *         description="Show all timesheets."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Show empty array"
    *     )
    * )
    */
    public function index()
    {
        $timesheets = Timesheet::with(['employee.paymentType', 'timesheetStatus'])->get();

        return $this->showAll($timesheets);
    }

    /**
    * @OA\Post(
    *     path="/api/timesheets",
    *     summary="Timesheet created successfully",
    *     @OA\Response(
    *         response=201,
    *         description="Timesheet created successfully."
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
            'employee_id' => 'required|integer|exists:employees,id',
            'timesheet_status_id' => 'required|integer|exists:timesheet_statuses,id',
            'amount' => 'nullable|integer',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        Timesheet::create([
            'employee_id' => $data['employee_id'],
            'timesheet_status_id' => $data['timesheet_status_id'],
            'amount' => $data['amount'],
            'note' => $data['note'],
        ]);

        return $this->successResponse([
            "message" => "Timesheet created successfully"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Timesheet $timesheet)
    {
        return $this->showOne($timesheet);
    }

    /**
    * @OA\Put(
    *     path="/api/timesheets/{timesheet}",
    *     summary="Timesheet updated successfully",
    *     @OA\Response(
    *         response=200,
    *         description="Timesheet updated successfully."
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
    public function update(Request $request, Timesheet $timesheet)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'employee_id' => 'nullable|integer|exists:employees,id',
            'timesheet_status_id' => 'nullable|integer|exists:timesheet_statuses,id',
            'amount' => 'nullable|integer',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (isset($data['employee_id'])) {
            $timesheet->employee_id = $data['employee_id'];
        }

        if (isset($data['timesheet_status_id'])) {
            $timesheet->timesheet_status_id = $data['timesheet_status_id'];
        }

        if (isset($data['amount'])) {
            $timesheet->amount = $data['amount'];
        }

        if (isset($data['note'])) {
            $timesheet->note = $data['note'];
        }

        $timesheet->save();

        return $this->successResponse([
            "message" => "Timesheet updated successfully"
        ], 200);
    }

    /**
    * @OA\Put(
    *     path="/api/timesheets/{timesheet}",
    *     summary="Timesheet updated successfully",
    *     @OA\Response(
    *         response=200,
    *         description="Timesheet updated successfully."
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
    public function destroy(Timesheet $timesheet)
    {
        $timesheet->delete();

        return $this->successResponse([
            "message" => "Timesheet deleted successfully"
        ], 200);
    }

    /**
     * Update the status of the specified timesheet.
     */
    public function updateStatus(Request $request, Timesheet $timesheet)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'timesheet_status_id' => 'required|integer|exists:timesheet_statuses,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $timesheet->timesheet_status_id = $data['timesheet_status_id'];
        $timesheet->save();

        return $this->successResponse([
            "message" => "Timesheet status updated successfully"
        ], 200);
    }
}
