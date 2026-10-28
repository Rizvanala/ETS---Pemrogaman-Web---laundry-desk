<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $outlets = Outlet::orderBy('id')->get();

        $staff = [
            ['name' => 'Rina Wulandari', 'email' => 'rina@laundrydesk.test'],
            ['name' => 'Dimas Prakoso', 'email' => 'dimas@laundrydesk.test'],
            ['name' => 'Hanif Maulana', 'email' => 'hanif@laundrydesk.test'],
        ];

        foreach ($staff as $index => $person) {
            User::create([
                'name' => $person['name'],
                'email' => $person['email'],
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'outlet_id' => $outlets[$index]->id,
            ]);
        }

        User::create([
            'name' => 'Bayu Santoso',
            'email' => 'bayu@laundrydesk.test',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);
    }
}
