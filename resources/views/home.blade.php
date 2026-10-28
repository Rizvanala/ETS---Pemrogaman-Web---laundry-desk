@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="hero">
    <div class="hero-text">
        <p class="eyebrow">Three outlets in Surabaya</p>
        <h1>Laundry Desk</h1>
        <p class="lead">Staff record every order, its status and its payments. Customers can log in to see their own bills.</p>
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
        <h2>How it works</h2>
        <ol class="steps">
            <li><strong>Received.</strong> Staff take in the laundry and the system calculates the total.</li>
            <li><strong>Finished.</strong> The laundry is done and the status is updated.</li>
            <li><strong>Collected.</strong> The customer picks it up. Payments are recorded until the balance is zero.</li>
        </ol>
    </div>
    <div>
        <h2>Services</h2>
        <ul class="price-lines">
            @foreach ($services as $service)
                <li><span>{{ $service->description }}</span><b>{{ \App\Support\Money::rupiah($service->price) }}</b></li>
            @endforeach
        </ul>
        <a href="{{ route('services.index') }}" class="text-link">Full price list &rarr;</a>
    </div>
</section>

<section>
    <h2>Gallery</h2>
    <div class="photo-strip">
        <figure class="photo-tile" style="background-image: linear-gradient(0deg, rgba(0,0,0,0.8), rgba(0,0,0,0.05) 60%), url('{{ asset('images/machines.jpg') }}')">
            <figcaption><b>Washing machines</b></figcaption>
        </figure>
        <figure class="photo-tile" style="background-image: linear-gradient(0deg, rgba(0,0,0,0.8), rgba(0,0,0,0.05) 60%), url('{{ asset('images/folding.jpg') }}')">
            <figcaption><b>Folded laundry</b></figcaption>
        </figure>
    </div>
</section>

<section>
    <h2>Outlets</h2>
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