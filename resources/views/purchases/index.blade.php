<!-- resources/views/purchases/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Purchases</h1>
        <h3 style="color: green">Total Purchases Price: {{ $totalPurchasesPrice }}</h3>
        <h3 style="color: red">Total Purchases Due Price: {{ $totalPurchasesDuePrice }}</h3>
    </div>
    <a href="{{ route('purchases.create') }}" class="btn btn-primary mb-2">Add Purchase</a>
    <table id="dataTable" class="table">
        <thead>
            <tr>
                <th>SR No.</th>
                <th>Product</th>
                <th>Company Name</th>
                <th>Category Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Paid Price</th>
                <th>Due Price</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchases as $key=> $purchase)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $purchase->product->name }}</td>
                    <td>{{ $purchase->company_name }}</td>
                    <td>{{ $purchase->product->category->name }}</td>
                    <td>{{ $purchase->quantity }}</td>
                    <td>{{ $purchase->price }}</td>
                    <td>{{ $purchase->total_price }}</td>
                    <td>{{ $purchase->pay_price }}</td>
                    <td>{{ $purchase->due_price }}</td>
                    <td style="white-space: nowrap;">{{ $purchase->date }}</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST"
                                style="margin: 0;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-button">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
