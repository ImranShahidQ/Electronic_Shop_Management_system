<!-- resources/views/claims/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Add Claim</h1>
    </div>
    <form action="{{ route('claims.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="product_id">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} ({{ $product->category->name }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" class="form-control" id="type" required>
                <option value="returned">Returned</option>
                <option value="received">Received</option>
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" class="form-control" id="quantity" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control" id="date" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
