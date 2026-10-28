@extends('layouts.app')

@section('title', 'Add customer')

@section('content')
<div class="page-head"><h1>Add customer</h1></div>

<form method="POST" action="{{ route('customers.store') }}" class="form form-wide">
    @include('customers._form')
    <div class="form-actions">
        <button type="submit" class="btn">Save customer</button>
        <a href="{{ route('customers.index') }}" class="btn btn-ghost">Cancel</a>
    </div>
</form>
@endsection
