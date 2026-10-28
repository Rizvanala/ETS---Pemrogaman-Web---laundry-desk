<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Service;
use App\Models\StatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $allowed = ['received', 'finished', 'collected', 'cancelled'];

        $bills = Bill::with(['customer', 'service', 'outlet'])
            ->withSum('payments', 'amount')
            ->when(in_array($status, $allowed, true), fn ($query) => $query->where('status', $status))
            ->orderByDesc('arrived_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('bills.index', compact('bills', 'status'));
    }

    public function create(Request $request)
    {
        return view('bills.create', [
            'customers' => Customer::orderBy('name')->get(),
            'services' => Service::orderBy('code')->get(),
            'outlet' => $request->user()->outlet,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'service_id' => ['required', 'exists:services,id'],
            'unit' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $staff = $request->user();
        abort_if($staff->outlet_id === null, 403, 'Your account is not assigned to an outlet.');

        // the price always comes from the database, never from the form
        $service = Service::findOrFail($data['service_id']);

        $bill = DB::transaction(function () use ($data, $service, $staff) {
            $bill = Bill::create([
                'code' => Bill::nextCode(),
                'customer_id' => $data['customer_id'],
                'service_id' => $service->id,
                'outlet_id' => $staff->outlet_id,
                'user_id' => $staff->id,
                'arrived_at' => now(),
                'unit' => $data['unit'],
                'total' => (float) $service->price * $data['unit'],
                'status' => 'received',
            ]);

            StatusLog::create([
                'bill_id' => $bill->id,
                'user_id' => $staff->id,
                'status' => 'received',
                'changed_at' => now(),
            ]);

            return $bill;
        });

        return redirect()->route('bills.show', $bill)
            ->with('success', "Bill {$bill->code} was taken in.");
    }

    public function show(Bill $bill)
    {
        $bill->load(['customer', 'service', 'outlet', 'clerk', 'payments.clerk', 'statusLogs.clerk']);

        return view('bills.show', [
            'bill' => $bill,
            'paid' => $bill->amountPaid(),
            'balance' => $bill->balance(),
        ]);
    }

    public function advance(Request $request, Bill $bill)
    {
        $next = $bill->nextStatus();

        if ($next === null) {
            return back()->with('error', "Bill {$bill->code} is already {$bill->status} and cannot move on.");
        }

        DB::transaction(function () use ($bill, $next, $request) {
            $bill->update(['status' => $next]);

            StatusLog::create([
                'bill_id' => $bill->id,
                'user_id' => $request->user()->id,
                'status' => $next,
                'changed_at' => now(),
            ]);
        });

        return redirect()->route('bills.show', $bill)
            ->with('success', "Bill {$bill->code} is now {$next}.");
    }

    public function pay(Request $request, Bill $bill)
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        if ($bill->status === 'cancelled') {
            return back()->with('error', 'A cancelled bill cannot receive payments.');
        }

        $balance = $bill->balance();

        if ($data['amount'] > $balance) {
            return back()
                ->withErrors(['amount' => 'The amount is more than the remaining balance.'])
                ->withInput();
        }

        Payment::create([
            'bill_id' => $bill->id,
            'user_id' => $request->user()->id,
            'amount' => $data['amount'],
            'paid_at' => now(),
        ]);

        return redirect()->route('bills.show', $bill)
            ->with('success', 'Payment was recorded.');
    }
}
