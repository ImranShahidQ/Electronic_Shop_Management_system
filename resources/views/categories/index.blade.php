<!-- resources/views/categories/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Categories</h1>
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-2">Add Category</a>
    <table id="dataTable" class="table">
        <thead>
            <tr>
                <th>SR No.</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $key=> $category)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td><a href="#" class="category-name" data-id="{{ $category->id }}">{{ $category->name }}</a></td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline-block;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div id="products-section" style="display:none;">
        <h3>Products</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody id="products-list">
                <!-- Products will be dynamically inserted here -->
            </tbody>
        </table>
        <h4>Total Price: <span id="total-price"></span></h4>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryLinks = document.querySelectorAll('.category-name');
            categoryLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const categoryId = this.getAttribute('data-id');
                    fetchCategoryProducts(categoryId);
                });
            });

            function fetchCategoryProducts(categoryId) {
                fetch(`/categories/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        const productsList = document.getElementById('products-list');
                        productsList.innerHTML = '';
                        data.products.forEach(product => {
                            const row = document.createElement('tr');
                            row.innerHTML = `<td>${product.name}</td><td>${product.total_price}</td>`;
                            productsList.appendChild(row);
                        });
                        document.getElementById('total-price').textContent = data.totalPrice;
                        document.getElementById('products-section').style.display = 'block';
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection
