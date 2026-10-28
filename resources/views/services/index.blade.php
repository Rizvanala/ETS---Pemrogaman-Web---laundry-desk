@extends('layouts.app')

@section('title', 'Price list')

@section('content')
<div class="page-head">
    <h1>Price list</h1>
</div>
<p class="muted">Prices are fixed per kilogram, piece, set or pair as written. The total of a bill is calculated by the server when the order is taken in.</p>

<div class="table-wrap">
    <table>
        <thead><tr><th>Code</th><th>Service</th><th class="num">Price</th></tr></thead>
        <tbody>
            @foreach ($services as $service)
                <tr>
                    <td class="mono">{{ $service->code }}</td>
                    <td>{{ $service->description }}</td>
                    <td class="num">{{ \App\Support\Money::rupiah($service->price) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
