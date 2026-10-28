<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['Wash and fold (per kg)', 8000],
            ['Wash, dry and iron (per kg)', 12000],
            ['Ironing only (per kg)', 6000],
            ['Express 6-hour wash and fold (per kg)', 15000],
            ['Bed cover (per piece)', 35000],
            ['Blanket (per piece)', 30000],
            ['Suit, two pieces (per set)', 45000],
            ['Shoe cleaning (per pair)', 40000],
        ];

        foreach ($services as $index => [$description, $price]) {
            Service::create([
                'code' => sprintf('S%04d', $index + 1),
                'description' => $description,
                'price' => $price,
            ]);
        }
    }
}
