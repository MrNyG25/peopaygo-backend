<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'payment_type_id' => \App\Models\PaymentType::inRandomOrder()->first()->id,
            'pay_rate' => $this->faker->numberBetween(15, 100),
            'customer_id' => \App\Models\Customer::inRandomOrder()->first()->id,
        ];
    }
}
