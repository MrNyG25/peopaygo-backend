<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Employee;
use App\Rules\FloridaPaymentValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends ApiController
{
    /**
    * @OA\Get(
    *     path="/api/employees",
    *     summary="Show all employees",
    *     @OA\Response(
    *         response=200,
    *         description="Show all employees."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Show empty array"
    *     )
    * )
    */
    public function index()
    {
        $employees = Employee::with('paymentType')->get();

        return $this->showAll($employees);
    }

    /**
    * @OA\Post(
    *     path="/api/employees",
    *     summary="Employee created successfully",
    *     @OA\Response(
    *         response=201,
    *         description="Employee created successfully."
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
            'name' => 'required|string|min:3|unique:employees',
            'payment_type_id' => 'required|integer|exists:payment_types,id',
            'pay_rate' => ['required','integer', new FloridaPaymentValidation],
            'customer_id' => 'required|integer|exists:customers,id',
            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        Employee::create([
            'name' => $data['name'],
            'payment_type_id' => $data['payment_type_id'],
            'pay_rate' => $data['pay_rate'],
            'customer_id' => $data['customer_id'],
        ]);

        return $this->successResponse([
            "message" => "Employee created successfully"
        ], 201);
    }

    /**
    * @OA\Get(
    *     path="/api/employees/{employee}",
    *     summary="Employee",
    *     @OA\Response(
    *         response=200,
    *         description="Employee info"
    *     ),
    *     @OA\Response(
    *         response="404",
    *         description="not found"
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Error Something went wrong"
    *     )
    * )
    */
    public function show(Employee $employee)
    {
        $employee->load('paymentType');

        return $this->showOne($employee);
    }

    /**
    * @OA\Put(
    *     path="/api/employees/{employee}",
    *     summary="Employee updated successfully",
    *     @OA\Response(
    *         response=200,
    *         description="Employee updated successfully."
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
    public function update(Request $request, Employee $employee)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'nullable|string|min:3',
            'payment_type_id' => 'nullable|integer|exists:payment_types,id',
            'pay_rate' => ['required','integer', new FloridaPaymentValidation],
            'customer_id' => 'nullable|integer|exists:customers,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (isset($data['name'])) {
            $employee->name = $data['name'];
        }

        if (isset($data['payment_type_id'])) {
            $employee->payment_type_id = $data['payment_type_id'];
        }

        if (isset($data['pay_rate'])) {
            $employee->pay_rate = $data['pay_rate'];
        }

        if (isset($data['customer_id'])) {
            $employee->customer_id = $data['customer_id'];
        }

        $employee->update();

        return $this->successResponse([
            "message" => "Employee updated successfully"
        ], 200);
    }

    /**
    * @OA\Delete(
    *     path="/api/employees/{employee}",
    *     summary="Employee deleted successfully",
    *     @OA\Response(
    *         response=200,
    *         description="Employee deleted successfully."
    *     ),
    *     @OA\Response(
    *         response="404",
    *         description="Employee not found"
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Error Something went wrong"
    *     )
    * )
    */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return $this->successResponse([
            "message" => "Employee deleted successfully"
        ], 200);
    }
}
