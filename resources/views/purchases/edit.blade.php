@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="mb-4">Edit Purchase</h1>
        </div>
        <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="company_name">Company Name</label>
                <input type="text" name="company_name" class="form-control" id="company_name" value="{{ old('company_name', $purchase->company_name) }}" required>
            </div>
            <div class="form-group">
                <label for="product_id">Product</label>
                <select name="product_id" id="product_id" class="form-control" required>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ $product->id == $purchase->product_id ? 'selected' : '' }}>
                            {{ $product->name }} ({{ $product->category->name }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" class="form-control" id="quantity" value="{{ old('quantity', $purchase->quantity) }}" required>
            </div>
            <div class="form-group">
                <label for="price">Total Price</label>
                <input type="number" step="0.01" name="price" class="form-control" id="price" value="{{ old('price', $purchase->price) }}" required>
            </div>
            <div class="form-group">
                <label for="pay_price">Paid Price</label>
                <input type="number" step="0.01" name="pay_price" class="form-control" id="pay_price" value="{{ old('pay_price', $purchase->pay_price) }}">
            </div>
            <div class="form-group">
                <label for="due_price">Due Price</label>
                <input type="number" step="0.01" name="due_price" class="form-control" id="due_price" value="{{ old('due_price', $purchase->due_price) }}" readonly>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" class="form-control" id="date" value="{{ old('date', $purchase->date ?? '') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityField = document.getElementById('quantity');
    const priceField = document.getElementById('price');
    const payPriceField = document.getElementById('pay_price');
    const duePriceField = document.getElementById('due_price');

    function updateTotalAndDuePrice() {
        const quantity = parseFloat(quantityField.value) || 0;
        const price = parseFloat(priceField.value) || 0;
        const totalPrice = quantity * price;
        const payPrice = parseFloat(payPriceField.value) || 0;
        const duePrice = totalPrice - payPrice;
        duePriceField.value = duePrice.toFixed(2);
    }

    quantityField.addEventListener('input', updateTotalAndDuePrice);
    priceField.addEventListener('input', updateTotalAndDuePrice);
    payPriceField.addEventListener('input', updateTotalAndDuePrice);
    updateTotalAndDuePrice();
});
</script>
@endsection