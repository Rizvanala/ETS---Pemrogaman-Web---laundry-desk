@extends('layouts.app')

@section('title', 'Bills')

@section('content')
<div class="page-head">
    <h1>Bills</h1>
    <a href="{{ route('bills.create') }}" class="btn">New bill</a>
</div>

<div class="filters">
    <a href="{{ route('bills.index') }}" class="{{ $status ? '' : 'on' }}">All</a>
    @foreach (['received', 'finished', 'collected', 'cancelled'] as $name)
        <a href="{{ route('bills.index', ['status' => $name]) }}" class="{{ $status === $name ? 'on' : '' }}">{{ ucfirst($name) }}</a>
    @endforeach
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Bill</th><th>Customer</th><th>Service</th><th>Outlet</th><th class="num">Total</th><th class="num">Balance</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($bills as $bill)
                <tr>
                    <td class="mono">{{ $bill->code }}</td>
                    <td>{{ $bill->customer->name }}</td>
                    <td>{{ $bill->service->description }}</td>
                    <td>{{ $bill->outlet->name }}</td>
                    <td class="num">{{ \App\Support\Money::rupiah($bill->total) }}</td>
                    <td class="num">{{ \App\Support\Money::rupiah($bill->total - ($bill->payments_sum_amount ?? 0)) }}</td>
                    <td>@include('partials.status', ['status' => $bill->status])</td>
                    <td class="actions"><a href="{{ route('bills.show', $bill) }}" class="text-link">Open</a></td>
                </tr>
            @empty
                <tr><td colspan="8" class="empty">No bills with this status.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@include('partials.pager', ['paginator' => $bills])
@endsection
