<!-- resources/views/sales/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Sales</h1>
        <h3 style="color: green">Total Sales Price: {{ $totalSalesPrice }}</h3>
        <h3 style="color: red">Total Sales Due Price: {{ $totalSalesDuePrice }}</h3>
    </div>
    <a href="{{ route('sales.create') }}" class="btn btn-primary mb-2">Add Sale</a>
    <table id="dataTable" class="table">
        <thead>
            <tr>
                <th>SR No.</th>
                <th>Product</th>
                <th>Customer Name</th>
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
            @foreach ($sales as $key=> $sale)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $sale->product->name }}</td>
                    <td>{{ $sale->customer_name }}</td>
                    <td>{{ $sale->product->category->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->price }}</td>
                    <td>{{ $sale->total_price }}</td>
                    <td>{{ $sale->pay_price }}</td>
                    <td>{{ $sale->due_price }}</td>
                    <td style="white-space: nowrap;">{{ $sale->created_at->format('Y-m-d') }}</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline;" class="delete-form">
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
