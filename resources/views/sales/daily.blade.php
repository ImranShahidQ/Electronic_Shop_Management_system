@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daily Report</h1>

    <h2>Sales of the Day</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->product->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->total_price }}</td>
                    <td>{{ $sale->date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Expenses of the Day</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
                <tr>
                    <td>{{ $expense->description }}</td>
                    <td>{{ $expense->amount }}</td>
                    <td>{{ $expense->date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Summary</h2>
    <p>Total Sales: {{ $totalSales }}</p>
    <p>Total Expenses: {{ $totalExpenses }}</p>
    <p>Net Profit: {{ $summary }}</p>
</div>
@endsection
