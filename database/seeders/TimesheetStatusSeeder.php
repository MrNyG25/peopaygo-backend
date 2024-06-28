<?php

namespace Database\Seeders;

use App\Models\TimesheetStatus;
use Illuminate\Database\Seeder;

class TimesheetStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1,  'name' =>'to pay'],
            ['id' => 2,  'name' =>'payed'],
        ];
        
        TimesheetStatus::insert($data);
    }
}
