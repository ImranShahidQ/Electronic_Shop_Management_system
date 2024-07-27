<!-- resources/views/purchases/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Add Purchase</h1>
    </div>
    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="company_name">Company Name</label>
            <input type="text" name="company_name" class="form-control" id="company_name" required>
        </div>
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
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" class="form-control" id="quantity" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" id="price" required>
        </div>
        <div class="form-group">
            <label for="pay_price">Paid Price</label>
            <input type="number" step="0.01" name="pay_price" class="form-control" id="pay_price">
        </div>
        {{-- <div class="form-group">
            <label for="due_price">Due Price</label>
            <input type="number" step="0.01" name="due_price" class="form-control" id="due_price" readonly>
        </div> --}}
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityField = document.getElementById('quantity');
    const priceField = document.getElementById('price');
    const payPriceField = document.getElementById('pay_price');
    const duePriceField = document.getElementById('due_price');

    // Function to calculate total price and update due price
    function updateTotalAndDuePrice() {
        const quantity = parseFloat(quantityField.value) || 0;
        const price = parseFloat(priceField.value) || 0;
        const totalPrice = quantity * price;

        // Update the due price based on pay price and total price
        const payPrice = parseFloat(payPriceField.value) || 0;
        const duePrice = totalPrice - payPrice;

        // Set the due price and total price fields
        duePriceField.value = duePrice.toFixed(2); // 2 decimal places
    }

    // Event listeners to update values
    quantityField.addEventListener('input', updateTotalAndDuePrice);
    priceField.addEventListener('input', updateTotalAndDuePrice);
    payPriceField.addEventListener('input', updateTotalAndDuePrice);

    // Initial calculation
    updateTotalAndDuePrice();
});
</script>
@endsection