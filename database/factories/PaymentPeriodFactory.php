<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentPeriod>
 */
class PaymentPeriodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'note' => $this->faker->sentence,
            'start_at' => $this->faker->date(),
            'end_at' => $this->faker->date(),
            'check_date' => $this->faker->date(),
        ];
    }
}
