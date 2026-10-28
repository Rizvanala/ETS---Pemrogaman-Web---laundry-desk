@extends('layouts.app')

@section('title', 'My bills')

@section('content')
<div class="page-head">
    <h1>My bills</h1>
</div>

@if ($customer)
    <p class="muted">Customer code <span class="mono">{{ $customer->code }}</span> &middot; {{ $customer->phone }}</p>

    <div class="summary">
        <div><span>Bills</span><b>{{ $bills->count() }}</b></div>
        <div><span>Outstanding balance</span><b class="{{ $outstanding > 0 ? 'owed' : '' }}">{{ \App\Support\Money::rupiah($outstanding) }}</b></div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Bill</th><th>Date</th><th>Service</th><th>Outlet</th><th class="num">Total</th><th class="num">Balance</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse ($bills as $bill)
                    <tr>
                        <td class="mono">{{ $bill->code }}</td>
                        <td>{{ $bill->arrived_at->format('d M Y') }}</td>
                        <td>{{ $bill->service->description }}</td>
                        <td>{{ $bill->outlet->name }}</td>
                        <td class="num">{{ \App\Support\Money::rupiah($bill->total) }}</td>
                        <td class="num">{{ \App\Support\Money::rupiah($bill->total - ($bill->payments_sum_amount ?? 0)) }}</td>
                        <td>@include('partials.status', ['status' => $bill->status])</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty">You have no bills yet. Drop your laundry at any outlet and it will appear here.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@else
    <p class="muted">Your account is not linked to a customer record yet. Please ask the staff at any outlet.</p>
@endif
@endsection
