<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    public function run(): void
    {
        $outlets = [
            ['name' => 'Keputih Outlet', 'address' => 'Jl. Keputih Tegal No. 12, Surabaya', 'phone' => '031-5990121'],
            ['name' => 'Gebang Outlet', 'address' => 'Jl. Gebang Putih No. 8, Surabaya', 'phone' => '031-5990122'],
            ['name' => 'Manyar Outlet', 'address' => 'Jl. Manyar Kertoarjo No. 31, Surabaya', 'phone' => '031-5990123'],
        ];

        foreach ($outlets as $outlet) {
            Outlet::create($outlet);
        }
    }
}
