<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyBillController extends Controller
{
    public function index(Request $request)
    {
        $customer = $request->user()->customer;

        $bills = $customer
            ? $customer->bills()
                ->with(['service', 'outlet'])
                ->withSum('payments', 'amount')
                ->orderByDesc('arrived_at')
                ->get()
            : collect();

        $outstanding = $bills->where('status', '!=', 'cancelled')
            ->sum(fn ($bill) => $bill->total - ($bill->payments_sum_amount ?? 0));

        return view('my-bills.index', compact('customer', 'bills', 'outstanding'));
    }
}
