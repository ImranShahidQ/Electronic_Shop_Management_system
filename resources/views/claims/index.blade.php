<!-- resources/views/claims/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Claims</h1>
        <h3 style="color: green">Total Claims Quantity: {{ $totalClaimsQuantity }}</h3>
    </div>
    <a href="{{ route('claims.create') }}" class="btn btn-primary mb-2">Add Claim</a>
    <table id="dataTable" class="table">
        <thead>
            <tr>
                <th>SR No.</th>
                <th>Product</th>
                <th>Category</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($claims as $key => $claim)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $claim->product->name }}</td>
                    <td>{{ $claim->product->category->name }}</td>
                    <td>{{ ucfirst($claim->type) }}</td>
                    <td>{{ $claim->quantity }}</td>
                    <td>{{ $claim->date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
