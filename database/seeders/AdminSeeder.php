<?php

namespace Database\Seeders;

use App\Models\User; 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admins = [
            [
                'name' => 'Utama Admin',
                'username' => 'admin',
                'email' => 'admin@banina.com',
                'password' => Hash::make('banina12345')
            ],
            [
                'name' => 'Staff Toko',
                'username' => 'staff',
                'email' => 'staff@banina.com',
                'password' => Hash::make('banina12345')
            ],
            [
                'name' => 'Manager Toko',
                'username' => 'manager',
                'email' => 'manager@banina.com',
                'password' => Hash::make('banina12345')
            ],
        ];

        foreach ($admins as $value) {
            User::updateOrCreate(
                ['username' => $value['username']], 
                [
                    'name' => $value['name'],
                    'email' => $value['email'],
                    'password' => $value['password']
                ]
            );
        }
    }
}