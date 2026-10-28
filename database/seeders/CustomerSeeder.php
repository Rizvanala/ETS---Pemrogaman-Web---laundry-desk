<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Bayu Santoso', 'Anisa Putri', 'Rizky Pratama', 'Salsa Maharani', 'Fajar Nugroho',
            'Dewi Lestari', 'Hendra Wijaya', 'Nadia Safitri', 'Yoga Permana', 'Citra Ayu',
            'Galih Setiawan', 'Intan Permata', 'Teguh Hidayat', 'Melati Kusuma', 'Arif Rahman',
            'Wulan Sari', 'Bagas Saputra', 'Laras Ningrum', 'Doni Firmansyah', 'Tiara Anggraini',
        ];

        $accountId = User::where('email', 'bayu@laundrydesk.test')->value('id');

        foreach ($names as $index => $name) {
            Customer::create([
                'code' => sprintf('C%04d', $index + 1),
                'name' => $name,
                'phone' => sprintf('0812%08d', 31000000 + ($index + 1) * 7919),
                'address' => 'Surabaya',
                'user_id' => $index === 0 ? $accountId : null,
            ]);
        }
    }
}
