<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Outlet;
use App\Models\Payment;
use App\Models\Service;
use App\Models\StatusLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::orderBy('id')->get();
        $services = Service::orderBy('id')->get();
        $outlets = Outlet::orderBy('id')->get();
        $staff = User::where('role', 'staff')->orderBy('id')->get();

        for ($i = 1; $i <= 30; $i++) {
            $customer = $customers[$i % $customers->count()];
            $service = $services[$i % $services->count()];
            $slot = $i % $outlets->count();
            $outlet = $outlets[$slot];
            $clerk = $staff[$slot];

            $unit = 1 + ($i * 3) % 6;
            $total = (float) $service->price * $unit;
            $arrived = Carbon::now()->subDays(31 - $i)->setTime(8 + $i % 9, 15, 0);

            $status = match ($i % 4) {
                0, 3 => 'collected',
                1 => 'received',
                default => 'finished',
            };
            if ($i === 7) {
                $status = 'cancelled';
            }

            $bill = Bill::create([
                'code' => sprintf('B%04d', $i),
                'customer_id' => $customer->id,
                'service_id' => $service->id,
                'outlet_id' => $outlet->id,
                'user_id' => $clerk->id,
                'arrived_at' => $arrived,
                'unit' => $unit,
                'total' => $total,
                'status' => $status,
            ]);

            $steps = ['received'];
            if (in_array($status, ['finished', 'collected'])) {
                $steps[] = 'finished';
            }
            if ($status === 'collected') {
                $steps[] = 'collected';
            }
            if ($status === 'cancelled') {
                $steps[] = 'cancelled';
            }

            foreach ($steps as $position => $step) {
                StatusLog::create([
                    'bill_id' => $bill->id,
                    'user_id' => $clerk->id,
                    'status' => $step,
                    'changed_at' => $arrived->copy()->addHours($position * 6),
                ]);
            }

            $paid = match (true) {
                $status === 'collected' => $total,
                $status === 'finished' => round($total / 2, 2),
                $status === 'received' && $i % 3 === 0 => round($total * 0.3, 2),
                default => 0,
            };

            if ($paid > 0) {
                Payment::create([
                    'bill_id' => $bill->id,
                    'user_id' => $clerk->id,
                    'amount' => $paid,
                    'paid_at' => $arrived->copy()->addHours(6),
                ]);
            }
        }
    }
}
