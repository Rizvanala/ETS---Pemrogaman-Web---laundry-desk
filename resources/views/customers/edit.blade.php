@extends('layouts.app')

@section('title', 'Edit customer')

@section('content')
<div class="page-head"><h1>Edit {{ $customer->code }}</h1></div>

<form method="POST" action="{{ route('customers.update', $customer) }}" class="form form-wide">
    @method('PUT')
    @include('customers._form')
    <div class="form-actions">
        <button type="submit" class="btn">Update customer</button>
        <a href="{{ route('customers.index') }}" class="btn btn-ghost">Cancel</a>
    </div>
</form>
@endsection
