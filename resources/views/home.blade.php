@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="hero">
    <div class="hero-text">
        <p class="eyebrow">Three outlets &middot; one ledger</p>
        <h1>Clothes in by morning.<br>Back by evening.</h1>
        <p class="lead">Every bill is priced by the server, every status change is logged with the name of the person who made it, and every payment is counted down to the last rupiah.</p>
        <div class="hero-actions">
            <a href="{{ route('services.index') }}" class="btn">See the price list</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-ghost">Create an account</a>
            @else
                <a href="{{ auth()->user()->isStaff() ? route('bills.index') : route('my-bills') }}" class="btn btn-ghost">Open my dashboard</a>
            @endguest
        </div>
    </div>
    <img src="{{ asset('images/hero-art.svg') }}" alt="Illustration of a front-loading washing machine" class="hero-art">
    <div class="hazard"></div>
</section>

<section class="split">
    <div>
        <h2>How a bill travels</h2>
        <ol class="steps">
            <li><strong>Received.</strong> Staff weigh or count the items, pick a service and the system fixes the total.</li>
            <li><strong>Finished.</strong> The wash is done. One click moves the bill forward, never backward.</li>
            <li><strong>Collected.</strong> The customer picks the order up. Payments can be split, the balance is always visible.</li>
        </ol>
    </div>
    <div>
        <h2>Popular services</h2>
        <ul class="price-lines">
            @foreach ($services as $service)
                <li><span>{{ $service->description }}</span><b>{{ \App\Support\Money::rupiah($service->price) }}</b></li>
            @endforeach
        </ul>
        <a href="{{ route('services.index') }}" class="text-link">Full price list &rarr;</a>
    </div>
</section>

<section>
    <h2>Inside the shop</h2>
    <div class="photo-strip">
        <figure class="photo-tile" style="background-image: linear-gradient(0deg, rgba(0,0,0,0.8), rgba(0,0,0,0.05) 60%), url('{{ asset('images/machines.jpg') }}')">
            <figcaption><b>Industrial machines</b><span>Sorted by load, washed in separate batches.</span></figcaption>
        </figure>
        <figure class="photo-tile" style="background-image: linear-gradient(0deg, rgba(0,0,0,0.8), rgba(0,0,0,0.05) 60%), url('{{ asset('images/folding.jpg') }}')">
            <figcaption><b>Folded and counted</b><span>Every order is checked against its bill before pickup.</span></figcaption>
        </figure>
    </div>
</section>

<section>
    <h2>Find an outlet</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Outlet</th><th>Address</th><th>Phone</th></tr></thead>
            <tbody>
                @foreach ($outlets as $outlet)
                    <tr><td>{{ $outlet->name }}</td><td>{{ $outlet->address }}</td><td class="mono">{{ $outlet->phone }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
