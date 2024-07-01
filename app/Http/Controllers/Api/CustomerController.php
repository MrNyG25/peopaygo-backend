<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends ApiController
{
    /**
    * @OA\Get(
    *     path="/api/customers",
    *     summary="Show all customers",
    *     @OA\Response(
    *         response=200,
    *         description="Show all customers."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="show empty array"
    *     )
    * )
    */
    public function index()
    {
        $customers = Customer::with('user')
                            ->orderBy('id', 'desc')
                            ->get();

        return $this->showAll($customers);
    }

    /**
    * @OA\Post(
    *     path="/api/customers",
    *     summary="Customer created successfully",
    *     @OA\Response(
    *         response=201,
    *         description="Customer created successfully."
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
            'name' => 'required|string|min:3',
            'email' => 'required|email:rfc|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        DB::beginTransaction();
        try{
            $user_id = User::insertGetId([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => User::CUSTOMER_ROLE,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Customer::create([
                'name' => $data['name'],
                'user_id' => $user_id,
            ]);
            DB::commit();
            return $this->successResponse([
                "message" => "Customer created successfully"
            ], 201);
        }catch (\Exception $ex) {
            DB::rollback();
            return $this->successResponse([
                "message" => "Error Something went wrong".$ex
            ], 500);
        }
    }

    /**
    * @OA\Get(
    *     path="/api/customers/{employee}",
    *     summary="customer",
    *     @OA\Response(
    *         response=200,
    *         description="Customers info"
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
    public function show(Customer $customer)
    {
        $customer->load('user');
        
        return $this->showOne($customer);
    }

    /**
    * @OA\Put(
    *     path="/api/customers/{customer}",
    *     summary="Customer updated successfully",
    *     @OA\Response(
    *         response=201,
    *         description="Customer updated successfully."
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
    public function update(Request $request, Customer $customer)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'nullable|string|min:3',
            'email' => 'nullable|email:rfc',
            'password' => 'nullable|string|min:8|confirmed',
            'change_password' => 'nullable|boolean',
            'actual_password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        DB::beginTransaction();
        try{

            $user = User::where('id',$customer->user_id)->first();


            if(isset($data['change_password']) && $data['change_password']){

                if(!isset($data['actual_password'])){
                    return $this->successResponse([
                        "message" => "Actual password is required"
                    ], 400);
                }

                if(!Hash::check($data['actual_password'], $user->password)){
                    return $this->successResponse([
                        "message" => "Actual password is wrong"
                    ], 400);
                }
                //update password
                $user->password = Hash::make($data['password']);
            }

            $user->name = $data['name'];
            $user->email = $data['email'];

            $user->update();

            $customer->name = $data['name'];

            $customer->update();
            DB::commit();
            return $this->successResponse([
                "message" => "Customer updated successfully"
            ], 201);
        }catch (\Exception $ex) {
            DB::rollback();
            return $this->successResponse([
                "message" => "Error Something went wrong".$ex
            ], 500);
        }
    }

}
