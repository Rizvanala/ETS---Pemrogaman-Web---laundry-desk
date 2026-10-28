@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="page-head">
    <h1>Customers</h1>
    <a href="{{ route('customers.create') }}" class="btn">Add customer</a>
</div>

<form method="GET" action="{{ route('customers.index') }}" class="search">
    <input type="text" name="q" value="{{ $q }}" placeholder="Search by name, code or phone">
    <button type="submit" class="btn btn-ghost">Search</button>
    @if ($q !== '')
        <a href="{{ route('customers.index') }}" class="text-link">Clear</a>
    @endif
</form>

<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Code</th><th>Name</th><th>Phone</th><th class="num">Bills</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <td class="mono">{{ $customer->code }}</td>
                    <td>{{ $customer->name }}</td>
                    <td class="mono">{{ $customer->phone }}</td>
                    <td class="num">{{ $customer->bills_count }}</td>
                    <td class="actions">
                        <a href="{{ route('customers.edit', $customer) }}" class="text-link">Edit</a>
                        <form method="POST" action="{{ route('customers.destroy', $customer) }}" onsubmit="return confirm('Delete this customer?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="link-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No customers match your search.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@include('partials.pager', ['paginator' => $customers])
@endsection
