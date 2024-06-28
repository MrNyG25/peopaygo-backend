<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1,  'name' =>'hour'],
            ['id' => 2,  'name' =>'salary'],
        ];
        
        PaymentType::insert($data);
    }
}
