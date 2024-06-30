<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TimesheetStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(TimesheetStatusSeeder::class);
        $this->call(UserSeeder::class);

        \App\Models\User::factory(10)->create();
        \App\Models\Customer::factory(10)->create();
        \App\Models\Employee::factory(10)->create();
        \App\Models\Timesheet::factory(10)->create();
        \App\Models\PaymentPeriod::factory(10)->create()->each(
            function($paymentPeriod){
                $timesheet = \App\Models\Timesheet::inRandomOrder()->first()->id;

                $paymentPeriod->timesheets()->attach($timesheet);
            }
        );

    }
}
