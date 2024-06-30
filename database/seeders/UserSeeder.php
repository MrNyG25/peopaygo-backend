<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1000,  
                'name' =>'admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('password123'),
                'role_id' => 1
            ],
        ];
        
        User::insert($data);
    }
}
