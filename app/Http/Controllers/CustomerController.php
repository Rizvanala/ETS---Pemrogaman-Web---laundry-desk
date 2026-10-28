<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'regex:/^[0-9+\- ]{6,30}$/'],
            'address' => ['nullable', 'string', 'max:120'],
        ];
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $customers = Customer::withCount('bills')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($inner) use ($q) {
                    $inner->where('name', 'like', "%{$q}%")
                        ->orWhere('code', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('customers.index', compact('customers', 'q'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['code'] = Customer::nextCode();

        $customer = Customer::create($data);

        return redirect()->route('customers.index')
            ->with('success', "Customer {$customer->code} ({$customer->name}) was added.");
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->validate($this->rules()));

        return redirect()->route('customers.index')
            ->with('success', "Customer {$customer->code} was updated.");
    }

    public function destroy(Customer $customer)
    {
        $count = $customer->bills()->count();

        if ($count > 0) {
            return redirect()->route('customers.index')
                ->with('error', "{$customer->name} cannot be deleted because they still have {$count} bill(s).");
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', "Customer {$customer->code} was deleted.");
    }
}
