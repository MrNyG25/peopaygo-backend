<?php

namespace Database\Factories;

use App\Models\Employee;
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
        return [
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'timesheet_status_id' => TimesheetStatus::inRandomOrder()->first()->id,
            'amount' => $this->faker->randomNumber(2),
            'note' => $this->faker->sentence,
        ];
    }
}
