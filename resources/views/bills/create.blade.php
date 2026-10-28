@extends('layouts.app')

@section('title', 'New bill')

@section('content')
<div class="page-head"><h1>Take in a new bill</h1></div>

<form method="POST" action="{{ route('bills.store') }}" class="form form-wide" id="bill-form">
    @csrf
    <label for="customer_id">Customer</label>
    <select id="customer_id" name="customer_id" required>
        <option value="">Choose a customer</option>
        @foreach ($customers as $customer)
            <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->code }} &middot; {{ $customer->name }}</option>
        @endforeach
    </select>
    @error('customer_id') <p class="field-error">{{ $message }}</p> @enderror

    <label for="service_id">Service</label>
    <select id="service_id" name="service_id" required>
        <option value="">Choose a service</option>
        @foreach ($services as $service)
            <option value="{{ $service->id }}" data-price="{{ (float) $service->price }}" @selected(old('service_id') == $service->id)>{{ $service->description }} &middot; {{ \App\Support\Money::rupiah($service->price) }}</option>
        @endforeach
    </select>
    @error('service_id') <p class="field-error">{{ $message }}</p> @enderror

    <label for="unit">Quantity (kg, pieces, sets or pairs)</label>
    <input id="unit" type="number" name="unit" min="1" max="100" value="{{ old('unit', 1) }}" required>
    @error('unit') <p class="field-error">{{ $message }}</p> @enderror

    <div class="summary">
        <div><span>Outlet</span><b>{{ $outlet->name ?? 'Not assigned' }}</b></div>
        <div><span>Estimated total</span><b id="preview-total">Rp 0</b></div>
    </div>
    <p class="muted small">The final total is calculated again by the server when you save.</p>

    <div class="form-actions">
        <button type="submit" class="btn">Save bill</button>
        <a href="{{ route('bills.index') }}" class="btn btn-ghost">Cancel</a>
    </div>
</form>

<script>
    const serviceSelect = document.getElementById('service_id');
    const unitInput = document.getElementById('unit');
    const previewTotal = document.getElementById('preview-total');

    function updatePreview() {
        const option = serviceSelect.options[serviceSelect.selectedIndex];
        const price = parseFloat(option.dataset.price || 0);
        const unit = parseInt(unitInput.value || 0, 10);
        const total = price * unit;
        previewTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    serviceSelect.addEventListener('change', updatePreview);
    unitInput.addEventListener('input', updatePreview);
    updatePreview();
</script>
@endsection
