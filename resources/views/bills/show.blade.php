@extends('layouts.app')

@section('title', 'Bill ' . $bill->code)

@section('content')
<div class="page-head">
    <h1>Bill {{ $bill->code }} @include('partials.status', ['status' => $bill->status])</h1>
    <a href="{{ route('bills.index') }}" class="btn btn-ghost">Back to bills</a>
</div>

<div class="split">
    <section>
        <h2>Details</h2>
        <dl class="facts">
            <dt>Customer</dt><dd>{{ $bill->customer->name }} <span class="mono muted">({{ $bill->customer->code }})</span></dd>
            <dt>Service</dt><dd>{{ $bill->service->description }}</dd>
            <dt>Quantity</dt><dd>{{ $bill->unit }}</dd>
            <dt>Outlet</dt><dd>{{ $bill->outlet->name }}</dd>
            <dt>Taken in by</dt><dd>{{ $bill->clerk->name }}</dd>
            <dt>Arrived</dt><dd>{{ $bill->arrived_at->format('d M Y, H:i') }}</dd>
        </dl>

        <div class="summary">
            <div><span>Total</span><b>{{ \App\Support\Money::rupiah($bill->total) }}</b></div>
            <div><span>Paid</span><b>{{ \App\Support\Money::rupiah($paid) }}</b></div>
            <div><span>Balance</span><b class="{{ $balance > 0 ? 'owed' : '' }}">{{ \App\Support\Money::rupiah($balance) }}</b></div>
        </div>

        @if ($bill->nextStatus())
            <form method="POST" action="{{ route('bills.advance', $bill) }}" class="inline-form">
                @csrf
                <button type="submit" class="btn">Move to {{ $bill->nextStatus() }}</button>
            </form>
        @else
            <p class="muted">This bill is {{ $bill->status }}. Its status cannot change any more.</p>
        @endif
    </section>

    <section>
        <h2>Status history</h2>
        <ul class="timeline">
            @foreach ($bill->statusLogs->sortBy('changed_at') as $log)
                <li>
                    @include('partials.status', ['status' => $log->status])
                    <span>{{ $log->changed_at->format('d M Y, H:i') }} &middot; {{ $log->clerk->name }}</span>
                </li>
            @endforeach
        </ul>
    </section>
</div>

<section>
    <h2>Payments</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Date</th><th>Recorded by</th><th class="num">Amount</th></tr></thead>
            <tbody>
                @forelse ($bill->payments->sortBy('paid_at') as $payment)
                    <tr>
                        <td>{{ $payment->paid_at->format('d M Y, H:i') }}</td>
                        <td>{{ $payment->clerk->name }}</td>
                        <td class="num">{{ \App\Support\Money::rupiah($payment->amount) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="empty">No payments yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($balance > 0 && $bill->status !== 'cancelled')
        <form method="POST" action="{{ route('bills.pay', $bill) }}" class="form pay-form">
            @csrf
            <label for="amount">Record a payment (Rp)</label>
            <div class="inline-fields">
                <input id="amount" type="number" name="amount" min="1" step="1" max="{{ (int) $balance }}" value="{{ old('amount') }}" required>
                <button type="submit" class="btn">Save payment</button>
            </div>
            @error('amount') <p class="field-error">{{ $message }}</p> @enderror
        </form>
    @else
        <p class="muted">Nothing left to pay on this bill.</p>
    @endif
</section>
@endsection
