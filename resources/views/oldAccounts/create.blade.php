@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Add Old Account</h1>
    </div>
    <form action="{{ route('oldAccounts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="customer_name">Customer Name</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="total_price">Total Price</label>
            <input type="number" name="total_price" step="0.01" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="pay_price">Paid Amount</label>
            <input type="number" name="pay_price" step="0.01" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="due_price">Due Amount</label>
            <input type="number" name="due_price" step="0.01" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Account</button>
    </form>
</div>
@endsection
