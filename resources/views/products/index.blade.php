<!-- resources/views/products/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Products</h1>
        <h3 style="color: green">Total Price of All Products: {{ $totalProductsPrice }}</h3>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-2">Add Product</a>
    <table id="dataTable" class="table">
        <thead>
            <tr>
                <th>SR No.</th>
                <th>Name</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $key=> $product)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->price }} RS</td>
                    <td>{{ $product->total_price }} RS</td>
                    <td style="white-space: nowrap;">{{ \Illuminate\Support\Carbon::parse($product->date)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline-block;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
