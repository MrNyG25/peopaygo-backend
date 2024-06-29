<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\PaymentType;
use App\Models\TimesheetStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timesheet>
 */
class TimesheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employee = Employee::inRandomOrder()->first();

        return [
            'employee_id' => $employee->id,
            'timesheet_status_id' => TimesheetStatus::inRandomOrder()->first()->id,
            'amount' => $employee->payment_type_id == PaymentType::HOURS ? $this->faker->randomNumber(2) : null ,
            'note' => $this->faker->sentence,
        ];
    }
}
