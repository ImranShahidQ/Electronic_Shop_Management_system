@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1>Old Accounts</h1>
            <h3 style="color: green">Total Dues Price Of All Old Accounts: {{ $totalDuesPrice }}</h3>
        </div>
        <a href="{{ route('oldAccounts.create') }}" class="btn btn-primary mb-3">Add Old Account</a>
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>SR No.</th>
                    <th>Customer Name</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Product Name</th>
                    <th>Total Price</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($oldCustomers as $key=> $customer)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $customer->customer_name }}</td>
                        <td>{{ $customer->phone_number }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->product_name }}</td>
                        <td>{{ $customer->total_price }}</td>
                        <td>{{ $customer->pay_price }}</td>
                        <td>{{ $customer->due_price }}</td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('oldAccounts.edit', $customer->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('oldAccounts.destroy', $customer->id) }}" method="POST"
                                    style="display:inline-block;" class="delete-form">
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
    </div>
@endsection

