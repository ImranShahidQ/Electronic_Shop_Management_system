@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>
    <!-- New Section: Category-wise Data -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Sales by Category</div>
                <div class="card-body">
                    @foreach($categories as $category)
                        <h5>{{ $category->name }}</h5>
                        <p>Total Sales Quantity: {{ $category->total_sales_quantity }}</p>
                        <ul>
                            @foreach($category->products as $product)
                                <li>
                                    {{ $product->name }}: {{ $product->total_sales_quantity }} (Sales)
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Purchases by Category</div>
                <div class="card-body">
                    @foreach($categories as $category)
                        <h5>{{ $category->name }}</h5>
                        <p>Total Purchases Quantity: {{ $category->total_purchases_quantity }}</p>
                        <ul>
                            @foreach($category->products as $product)
                                <li>
                                    {{ $product->name }}: {{ $product->total_purchases_quantity }} (Purchases)
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Products by Category</div>
                <div class="card-body">
                    @foreach($categories as $category)
                        <h5>{{ $category->name }}</h5>
                        {{-- <p>Total Products: {{ $category->total_products }}</p> --}}
                        <p>Total Stock: {{ $category->total_stock }}</p>
                        <ul>
                            @foreach($category->products as $product)
                                <li>
                                    {{ $product->name }}: Stock {{ $product->stock }}
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <p class="card-text">Manage product categories</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-light">View Categories</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Products</div>
                <div class="card-body">
                    <p class="card-text">Manage products</p>
                    <a href="{{ route('products.index') }}" class="btn btn-light">View Products</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Sales</div>
                <div class="card-body">
                    <p class="card-text">Manage sales</p>
                    <a href="{{ route('sales.index') }}" class="btn btn-light">View Sales</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Purchases</div>
                <div class="card-body">
                    <p class="card-text">Manage purchases</p>
                    <a href="{{ route('purchases.index') }}" class="btn btn-light">View Purchases</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Expenses</div>
                <div class="card-body">
                    <p class="card-text">Manage expenses</p>
                    <a href="{{ route('expenses.index') }}" class="btn btn-light">View Expenses</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Old Accounts</div>
                <div class="card-body">
                    <p class="card-text">Manage Accounts</p>
                    <a href="{{ route('oldAccounts.index') }}" class="btn btn-light">View Old Accounts</a>
                </div>
            </div>
        </div>
    </div>
@endsection
