@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sale Details</h1>
    <div class="card">
        <div class="card-header">
            Sale #{{ $sale->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Product: {{ $sale->product->name }}</h5>
            <p class="card-text"><strong>Quantity:</strong> {{ $sale->quantity }}</p>
            <p class="card-text"><strong>Price:</strong> {{ $sale->price }}</p>
            <p class="card-text"><strong>Total Price:</strong> {{ $sale->total_price }}</p>
            <p class="card-text"><strong>Customer Name:</strong> {{ $sale->customer_name }}</p>
            <p class="card-text"><strong>Pay Price:</strong> {{ $sale->pay_price }}</p>
            <p class="card-text"><strong>Due Price:</strong> {{ $sale->due_price }}</p>
            <a href="{{ route('sales.index') }}" class="btn btn-primary">Back to Sales</a>
        </div>
    </div>
</div>
@endsection
